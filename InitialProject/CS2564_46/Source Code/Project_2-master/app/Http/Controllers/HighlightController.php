<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;
use App\Models\images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\Tags;

class HighlightController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:highlight-list');
    }

    // แสดงรายการ Highlight Papers

    public function index()
    {
        $highlights = Highlight::paginate(10);
        $tags = Tags::paginate(10); // ✅ ดึง Tags ทั้งหมดจาก DB
        return view('highlight.index', compact('tags', 'highlights')); // ✅ ส่งตัวแปร $tags ไปยัง View
    }

    /**
     * แสดงฟอร์มสร้าง Highlight
     */
    public function create()
    {
        $tags = Tags::all();
        return view('highlight.create', compact('tags'));
    }

    /**
     * บันทึกข้อมูล Highlight และอัปโหลดรูปภาพ
     */
    public function store(Request $request)
    {
        // ✅ ตรวจสอบข้อมูลที่รับมา
        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required' // ✅ แก้จาก `string` เป็น `required` อย่างเดียว
        ]);

        // ✅ ตรวจสอบและสร้างโฟลเดอร์
        $coverFolder = public_path('images/coverimg');
        $albumFolder = public_path('images/albumimg');

        if (!File::exists($coverFolder))
            File::makeDirectory($coverFolder, 0777, true, true);
        if (!File::exists($albumFolder))
            File::makeDirectory($albumFolder, 0777, true, true);

        // ✅ อัปโหลด Cover Image
        $coverImage = $request->file('cover_image');
        $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
        $coverImage->move($coverFolder, $coverImageName);
        $coverPath = 'images/coverimg/' . $coverImageName;

        // ✅ ดึงชื่อผู้ใช้จาก Auth
        $user = Auth::user();
        $creatorName = $user->fname_th;

        // ✅ สร้าง Highlight ใหม่
        $highlight = Highlight::create([
            'title' => $request->title,
            'detail' => $request->detail,
            'cover_image' => $coverPath,
            'creator' => $creatorName,
            'active' => false
        ]);

        // ✅ อัปโหลดหลายรูปไปยัง `public/images/albumimg`
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move($albumFolder, $imageName);
                $imagePath = 'images/albumimg/' . $imageName;

                images::create([
                    'highlight_id' => $highlight->id,
                    'image_path' => $imagePath
                ]);
            }
        }

        // ✅ แปลง Tags ให้อยู่ในรูปแบบ Array แล้วบันทึก
        $selectedTags = is_array($request->tags) ? $request->tags : explode(",", $request->tags);
        $highlight->tags()->sync($selectedTags);

        return redirect()->route('highlight.index')->with('success', 'Highlight ถูกสร้างเรียบร้อยแล้ว!');
    }

    // ✅ ฟังก์ชันแก้ไข Highlight
    public function edit($id)
    {
        $highlight = Highlight::with('tags', 'images')->findOrFail($id);
        $tags = Tags::all();
        return view('highlight.edit', compact('highlight', 'tags'));
    }

    // ✅ ฟังก์ชันอัปเดต Highlight
    // ✅ ฟังก์ชันอัปเดต Highlight
    public function update(Request $request, $id)
    {
        $highlight = Highlight::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required',
            'active' => 'required|boolean'  // ✅ เพิ่มการตรวจสอบค่า active
        ]);

        $highlight->title = $request->title;
        $highlight->detail = $request->detail;
        $highlight->active = $request->active; // ✅ อัปเดต Active Status

        // ✅ อัปเดต Cover Image ถ้ามีการเปลี่ยนแปลง
        if ($request->hasFile('cover_image')) {
            if (File::exists(public_path($highlight->cover_image))) {
                File::delete(public_path($highlight->cover_image));
            }
            $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('images/coverimg'), $coverImageName);
            $highlight->cover_image = 'images/coverimg/' . $coverImageName;
        }

        $highlight->save();

        // ✅ อัปโหลดรูปใหม่ถ้ามี
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/albumimg'), $imageName);
                $imagePath = 'images/albumimg/' . $imageName;

                images::create([
                    'highlight_id' => $highlight->id,
                    'image_path' => $imagePath
                ]);
            }
        }

        // ✅ อัปเดต Tags
        $selectedTags = is_array($request->tags) ? $request->tags : explode(",", $request->tags);
        $highlight->tags()->sync($selectedTags);

        return redirect()->route('highlight.index')->with('success', 'Highlight ถูกอัปเดตเรียบร้อยแล้ว!');
    }


    // ✅ ฟังก์ชันลบรูปภาพ
    public function deleteImage($id)
    {
        $image = images::where('id', $id)->first();

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'ไม่พบรูปภาพที่ต้องการลบ!']);
        }

        // ลบไฟล์ออกจากโฟลเดอร์
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        // ลบออกจากฐานข้อมูล
        $image->delete();

        return response()->json(['success' => true, 'message' => 'ลบรูปภาพเรียบร้อยแล้ว!']);
    }




    // ✅ ฟังก์ชันลบ Highlight
    public function destroy($id)
    {
        $highlight = Highlight::findOrFail($id);

        // ✅ ลบ Cover Image
        if (File::exists(public_path($highlight->cover_image))) {
            File::delete(public_path($highlight->cover_image));
        }

        // ✅ ลบ Images ที่เกี่ยวข้อง
        foreach ($highlight->images as $image) {
            if (File::exists(public_path($image->image_path))) {
                File::delete(public_path($image->image_path));
            }
            $image->delete();
        }

        // ✅ ลบ Tags ที่เกี่ยวข้อง
        $highlight->tags()->detach();

        // ✅ ลบ Highlight
        $highlight->delete();

        return redirect()->route('highlight.index')->with('success', 'Highlight ถูกลบเรียบร้อยแล้ว!');
    }

    public function toggleActive(Request $request, $id)
    {
        // นับจำนวน Highlight ที่ active อยู่
        $activeCount = Highlight::where('active', true)->count();

        // ตรวจสอบว่าถ้าเปิดเกิน 5 ให้ return กลับไป
        if ($activeCount >= 5 && $request->input('active') == 1) {
            return redirect()->route('highlight.index')->with('error', '❌ ไม่สามารถเปิด Active เกิน 5 รายการได้!');
        }

        $highlight = Highlight::findOrFail($id);
        $highlight->active = $request->input('active', 0);
        $highlight->save();

        return redirect()->route('highlight.index')->with('success', '✅ อัปเดตสถานะสำเร็จ');
    }

    public function show($id)
    {
        $highlight = Highlight::with('images', 'tags')->findOrFail($id);
        return view('highlightdetail', compact('highlight'));
    }


}
