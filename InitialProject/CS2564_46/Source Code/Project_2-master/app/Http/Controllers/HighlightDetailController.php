<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;

use Illuminate\Mail\Markdown;

class HighlightDetailController extends Controller{

    public function show($id)
    {
        $highlight = Highlight::findOrFail($id);

        $markdown = app(Markdown::class);
        $highlight->content = $markdown->parse($highlight->detail);
        
        return view('highlightdetail', compact('highlight'));
    }
}