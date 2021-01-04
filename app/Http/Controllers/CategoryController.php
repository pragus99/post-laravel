<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts = $category->posts()->latest()->paginate(10);              // paginate to resolve error with PostController index
        return view('posts.index', compact('posts', 'category'));
    }
}
