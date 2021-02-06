<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;



Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('search', [SearchController::class, 'post'])->name('search.post');

Route::middleware('auth')->prefix('posts')->group(function () {
    Route::get('create', [PostController::class, 'create'])->name('posts.create');
    Route::post('store', [PostController::class, 'store']);
    Route::get('edit/{post:slug}', [PostController::class, 'edit']);
    Route::patch('edit/{post:slug}', [PostController::class, 'update']);
    Route::delete('destroy/{post:slug}', [PostController::class, 'destroy']); 
});

Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('tags/{tag:slug}', [TagController::class, 'show'] )->name('tag.show');
Route::get('posts/show/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/contact', 'contact');
Route::view('/about', 'about');