@extends('layouts.app',  ['title' => 'Home'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                @forelse ($posts as $post)
                <div class="col-md-6">
                    <div class="card mb-4">
            
                        @if ($post->thumbnail)
                        {{-- <img src="{{ asset("storage/" . $post->thumbnail) }}" alt="#" class="card-img-top" height="100"> --}}
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img src="{{ asset($post->takeImage()) }}" alt="" class="card-img-top"
                                style="height:300px;object-fit: cover;object-position:center;">
                        </a>
                        @endif
            
                        <div class="card-body">
            
                            <div>
                                <a href="{{ route('category.show', $post->category->slug) }}">
                                    <small>{{ $post->category->name }}</small></a> -
            
                                @foreach ($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}">
                                    <small>{{ $tag->name }}</small></a>
                                @endforeach
                            </div>
                            <hr>
                            <a href="{{ route('posts.show', $post->slug) }}" class="card-title text-dark">
                                <h3>{{ $post->title }}</h3>
                            </a>
            
                            <div>
                                {{ Str::limit($post->body, 110, '') }}
                            </div>
                            
                            {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <div class="media align-items-center ">
                                        <img src="{{ $post->user->gravatar() }}" alt="">
                                        <div class="media-body ml-2">
                                            <div>
                                                {{ $post->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-secondary">
                                    Published on {{ $post->created_at->format('d M, Y') }}
                                   or ->differForHumans (after created_at).
                                   or  @if (auth()->user()->is($post->user))
                                </div>
                            </div> --}}
    
                        </div>
                    </div>
                </div>
            
                @empty
                <div class="col-md-6">
                    <div class="alert alert-info">
                        There no Post.
                    </div>
                </div>
                @endforelse
            
            </div>
        </div>
    </div>
</div>
@endsection
