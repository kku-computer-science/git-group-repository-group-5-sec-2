<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;

class AllHighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::orderBy('created_at', 'desc')->get();
        return view('allhighlights.index', compact('highlights'));
    }




}
