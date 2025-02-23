<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    //แสดง create
    public function create(){
        return view('tags.create');
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่รับเข้ามา
        $request->validate([
            'name' => 'required|string|max:100|unique:tags,name',
        ]);

        // บันทึกข้อมูล
        Tags::create([
            'name' => $request->name,
        ]);

        // ✅ Redirect กลับไปหน้า highlight.index หลังจากสร้างแท็กสำเร็จ
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
            'name' => 'required|string|max:100|unique:tags,name,'.$id,
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
}
