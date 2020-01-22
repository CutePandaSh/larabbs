<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    //
    public function show(Category $category, Request $request, User $user, Link $link)
    {
        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();
        $topics = Topic::where('category_id', $category->id)
                    ->withOrder($request->order)
                    ->with('user')->paginate(20);

        return view('topics.index', compact('category', 'topics', 'active_users', 'links'));
    }
}
