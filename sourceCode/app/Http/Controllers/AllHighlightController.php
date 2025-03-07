<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;
use App\Models\Tags;

class AllHighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::orderBy('created_at', 'desc')->get();
        $tags = Tags::all();
        return view('allhighlights.index', compact('highlights', 'tags'));
    }




}
