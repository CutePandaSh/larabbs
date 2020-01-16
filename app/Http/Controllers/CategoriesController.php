<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;
// use App\Models\User;

class CategoriesController extends Controller
{
    //
    public function show(Category $category, Request $request)
    {
        $topics = Topic::where('category_id', $category->id)
                    ->withOrder($request->order)
                    ->with('user')->paginate(20);

        return view('topics.index', compact('category', 'topics'));
    }
}
