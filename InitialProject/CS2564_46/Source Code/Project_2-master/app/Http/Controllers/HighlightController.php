<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight_paper;
use App\Models\Paper;
use App\Models\User;
use App\Models\Tags;

class HighlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:highlight-list');
    }

    // แสดงรายการ Highlight Papers

    public function index()
    {
        $tags = Tags::all(); // ✅ ดึง Tags ทั้งหมดจาก DB
        return view('highlight.index', compact('tags')); // ✅ ส่งตัวแปร $tags ไปยัง View
    }
}
