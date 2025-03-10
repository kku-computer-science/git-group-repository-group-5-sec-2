<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\Highlight;
use Illuminate\Support\Facades\DB;

class SearchTagController extends Controller
{
    public function index(Request $request)
    {
        $availableTags = Tags::all();

        $filterTags = $request->has('tags') ? explode(',', $request->input('tags')) : [];


        $tagsModel = new Tags();

        if(empty($filterTags) || $filterTags[0] == '') {
            $highlights = Highlight::all();
        } else {
            $highlights = $tagsModel->filteredHighlights($filterTags);
        }

        //$highlights = empty($filterTags) ? Highlight::all() : $tagsModel->filteredHighlights($filterTags);

        return view('search_result', compact('highlights', 'availableTags'));
    }
}