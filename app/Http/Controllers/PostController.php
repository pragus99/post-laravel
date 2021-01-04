<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\{Category, Post, Tag};
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except([
    //         'index', 'show'
    //     ]);
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::Latest()->paginate(10);                  // using bootstrap instead taildwind css
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('posts.create', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // $post = new Post;
        // $post->title = $request->title;
        // $post->slug = Str::slug($request->title);
        // $post->body = $request->body;
        // $post->save();

        // $this->validate($request, [
        //     'title' => 'required|max:191',
        //     'body' => 'required'
        // ]);
        // request()->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        // ]);

        $request->validate([
            'thumbnail' => 'image|mimes:jpg,jpeg,svg,png|max:50000'
        ]);
        $attr = $request->all();
        $attr['slug'] = Str::slug(request('title'));

        $thumbnail = request()->file('thumbnail') ? $thumbnail = request()->file('thumbnail')->store("images/posts") : null;

        // if (request()->file('thumbnail')) {
        //     $thumbnail = request()->file('thumbnail')->store("images/posts");
        // } else {
        //     $thumbnail = null;
        // }
        
        // $slug = Str::slug(request('title'));     // and for thumbnail
        // $attr['slug'] = $slug;                   // and for thumbnail

        

        // $thumbnailUrl = $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");
        
        // $attr['user_id'] = auth()->id();

        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;

        $post = auth()->user()->posts()->create($attr);            

        $post->tags()->attach(request('tags'));
            
        // return back();
        // session()->flash('error', 'The post was failed to create');
        
        session()->flash('success', 'The post was created');

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $posts = Post::where('category_id', $post->category_id)->latest()->limit(4)->get();
        return view('posts.show', compact('post', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // $request->validate([
        //     'thumbnail' => 'image|mimes: jpg,jpeg,svg,png|max:50000'
        // ]);
        $attr = $request->all();

        $this->authorize('update', $post);

        if (request()->file('thumbnail')) {
            Storage::delete($post->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('images/posts');
        } else {
            $thumbnail = $post->thumbnail;
        };

        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;

        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        // if(auth()->user()->is($post->user)) {
            Storage::delete($post->thumbnail);
            
            $post->tags()->detach();
            $post->delete();

            session()->flash('success', 'the post was deleted');
            return redirect('/posts');

        // } else {

            session()->flash('error', "this wasn't your post");
            return redirect('posts');
        // }
    }
}