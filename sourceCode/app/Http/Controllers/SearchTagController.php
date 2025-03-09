<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\Highlight;

class SearchTagController extends Controller
{
    public function index()
    {
        // ค้นหา Tag ตามชื่อ
        $tags = Tags::all();

        // ดึงผลงานทั้งหมดที่มี Tag นั้น
        $highlights = Highlight::all();
    
        // ส่งไปยัง View
        return view('search_result', compact('highlights', 'tags'));
    }
}