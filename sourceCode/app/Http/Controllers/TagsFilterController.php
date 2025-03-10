<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;


class TagsFilterController extends Controller
{
    public function filterByTag($tagName)
{
    // ค้นหา Tag ตามชื่อ
    $tag = Tags::where('name', $tagName)->first();

    if (!$tag) {
        return redirect()->back()->with('error', 'Tag not found');
    }

    // ดึงผลงานทั้งหมดที่มี Tag นั้น
    $highlights = $tag->highlights()->get();

    // ส่งไปยัง View
    return view('filtered', compact('highlights', 'tagName'));
}


}