<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight_paper;
use App\Models\Paper;
use App\Models\User;

class HighlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:highlight-list');
    }
    // แสดงรายการ Highlight Papers

    public function index(Request $request)
    {
        $query = Highlight_paper::with('paper');

        // เพิ่มการ filter
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'selected':
                    $query->where('isSelected', true);
                    break;
                case 'not-selected':
                    $query->where('isSelected', false);
                    break;
            }
        }

        $highlight_papers = $query->orderBy('id', 'asc')->paginate(10);
        return view('highlight.index', compact('highlight_papers'));
    }


    // แสดงฟอร์มสร้าง Highlight Paper
    // public function create()
    // {
    //     $papers = Paper::select('id', 'paper_name')->get();
    //     return view('highlight.create', compact('papers'));
    // }

    public function create()
    {
        $researchers = User::role(['teacher', 'student'])->select('id', 'fname_th', 'lname_th')->get();

        // ดึงงานวิจัยทั้งหมด
        $allPapers = Paper::select('id', 'paper_name')->get();

        // ดึง papers ตาม researcher
        $papersByResearcher = [];
        $researchers->each(function ($researcher) use (&$papersByResearcher) {
            $papersByResearcher[$researcher->id] = $researcher->paper()
                ->select('papers.id', 'papers.paper_name') // ✅ ระบุให้ชัดเจน
                ->get();
        });

        return view('highlight.create', [
            'researchers' => $researchers,
            'allPapers' => $allPapers,
            'papersByResearcher' => $papersByResearcher
        ]);
    }




    // บันทึกข้อมูล Highlight Paper ลงฐานข้อมูล
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isSelected' => 'boolean',
            'paper_id' => 'required|exists:papers,id'
        ]);

        $data = $request->except('_token');
        $data['isSelected'] = $request->input('isSelected', 0);


        // อัปโหลดไฟล์ภาพถ้ามี
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // ตั้งชื่อไฟล์ใหม่กันซ้ำ
            $image->move(public_path('images/highlight_papers'), $imageName); // ✅ เก็บที่ public/images/highlight_papers/
            //$data['picture'] = 'images/highlight_papers/' . $imageName; // ✅ เก็บ path ในฐานข้อมูล
            $data['picture'] = '' . $imageName; // ไม่จำเป็นต้องเก็บ path ในฐานข้อมูล
        }

        Highlight_paper::create($data);

        return redirect()->route('highlight.index')->with('success', 'Highlight Paper created successfully.');
    }

    public function edit($id)
    {
        $highlight_paper = Highlight_paper::findOrFail($id);
        $researchers = User::role(['teacher', 'student'])->select('id', 'fname_th', 'lname_th')->get();

        // ดึงงานวิจัยทั้งหมด
        $allPapers = Paper::select('id', 'paper_name')->get();

        // ดึง papers ตาม researcher
        $papersByResearcher = [];
        $researchers->each(function ($researcher) use (&$papersByResearcher) {
            $papersByResearcher[$researcher->id] = $researcher->paper()
                ->select('papers.id', 'papers.paper_name')
                ->get();
        });

        // หานักวิจัยที่เป็นเจ้าของ Paper ที่เลือกอยู่
        $selectedResearcher = null;
        foreach ($researchers as $researcher) {
            if ($researcher->paper()->where('papers.id', $highlight_paper->paper_id)->exists()) {
                $selectedResearcher = $researcher->id;
                break;
            }
        }

        return view('highlight.edit', [
            'highlight_paper' => $highlight_paper,
            'researchers' => $researchers,
            'allPapers' => $allPapers,
            'papersByResearcher' => $papersByResearcher,
            'selectedResearcher' => $selectedResearcher
        ]);
    }


    // อัปเดตข้อมูล Highlight Paper
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isSelected' => 'boolean',
            'paper_id' => 'required|exists:papers,id'
        ]);

        $highlight_paper = Highlight_paper::findOrFail($id);

        $data = $request->except('_token');
        $data['isSelected'] = $request->input('isSelected', 0);


        // ถ้ามีการอัปโหลดรูปใหม่ ให้ลบรูปเก่าก่อน
        if ($request->hasFile('picture')) {
            // ลบรูปเก่าถ้ามี
            if ($highlight_paper->picture && file_exists(public_path($highlight_paper->picture))) {
                unlink(public_path($highlight_paper->picture));
            }

            // อัปโหลดรูปใหม่
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // ตั้งชื่อไฟล์ใหม่กันซ้ำ
            $image->move(public_path('images/highlight_papers'), $imageName); // ✅ เก็บที่ public/images/highlight_papers/
            $data['picture'] = 'images/highlight_papers/' . $imageName; // ✅ เก็บ path ในฐานข้อมูล
        }

        $highlight_paper->update($data);

        return redirect()->route('highlight.index')->with('success', 'Highlight Paper updated successfully.');
    }


    // ลบข้อมูล Highlight Paper
    public function destroy($id)
    {
        $highlight_paper = Highlight_paper::findOrFail($id);

        // ลบไฟล์รูปภาพถ้ามี
        if ($highlight_paper->picture && file_exists(public_path($highlight_paper->picture))) {
            unlink(public_path($highlight_paper->picture));
        }

        $highlight_paper->delete();

        // เพิ่ม filter parameter กลับไปยังหน้า index
        return redirect()->route('highlight.index', request()->query())
            ->with('success', 'Highlight Paper deleted successfully.');
    }
}
