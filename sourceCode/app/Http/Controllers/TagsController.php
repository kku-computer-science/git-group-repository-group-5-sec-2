<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    // แสดงรายการ tags ทั้งหมด
    public function index()
    {
        $tags = Tags::orderBy('name')->paginate(20);
        return view('tags.index', compact('tags'));
    }

    //แสดง create
    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name',
        ], [
            'name.unique' => 'ชื่อแท็กซ้ำ', // กำหนดข้อความเองเมื่อชื่อซ้ำ
        ]);

        Tags::create([
            'name' => $request->name,
        ]);

        return redirect()->route('highlight.index')->with('success', 'Tag ถูกสร้างเรียบร้อยแล้ว!');
    }


    // ✅ แสดงฟอร์มแก้ไขแท็ก
    public function edit($id)
    {
        $tag = Tags::findOrFail($id);
        return view('tags.edit', compact('tag'));
    }

    // ✅ อัปเดตข้อมูลแท็ก
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name,' . $id,
        ]);

        $tag = Tags::findOrFail($id);
        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('highlight.index')->with('success', 'Tag ถูกอัปเดตเรียบร้อยแล้ว!');
    }

    // ✅ ลบแท็ก
    public function destroy($id)
    {
        $tag = Tags::findOrFail($id);
        $tag->delete();

        return redirect()->route('highlight.index')->with('success', 'Tag ถูกลบเรียบร้อยแล้ว!');
    }

    /**
     * API สำหรับดึงข้อมูล Tags ทั้งหมดในรูปแบบ JSON
     * สำหรับใช้ใน Autocomplete
     */
    public function list()
    {
        $tags = Tags::orderBy('name')->get();
        return response()->json($tags);
    }
}