@extends('layouts.app', ['title' => 'Post'])

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-5">

                <div class="card-header">
                    <h1>{{ $post->title }}</h1>
                    <div class="secondary-text"><a
                            href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a> - Published
                        {{ $post->created_at->format('d M, Y') }}
                        - @foreach ($post->tags as $tag)
                        <a href="/tags/{{ $tag->slug }}">{{ $tag->name }}</a>
                        @endforeach</div>

                </div>
                <div class="card-body">
                    @if ($post->thumbnail)
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <img src="{{ asset($post->takeImage()) }}" alt="" class="card-img-top"
                            style="height:400px;object-fit: cover;object-position:center;">
                    </a>
                    @endif
                    <p> {!! nl2br($post->body) !!}</p>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="media">
                            <img src="{{ $post->user->gravatar() }}" alt="" class="mr-2">
                            <div class="media-body">
                                <div>
                                    {{ $post->user->name }}
                                </div>
                                <div>
                                    {{'@' . $post->user->username  }}
                                </div>
                            </div>
                        </div>
                        {{-- @if(auth()->user()->id == $post->user_id)  --}}
                        {{-- @if(auth()->user()->is($post->user)) --}}
                        <div>
                            @can('update', $post)
                            <a href="/posts/edit/{{ $post->slug }}" class="btn btn-sm btn-success mr-2">Edit</a>
                            @endcan

                            @can('update', $post)
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"
                                type="submit">
                                delete
                            </button>
                            @include('posts.partials.modal-delete')
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @foreach ($posts as $post)
            <div class="card mb-4">

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
                        <h4>{{ $post->title }}</h4>
                    </a>

                    <div class="text-secondary">
                        {{ Str::limit($post->body, 50, '') }}
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="media align-items-center ">
                                <img src="{{ $post->user->gravatar() }}" alt="">
                                <div class="media-body ml-2">
                                    <div>
                                        {{ $post->user->name }}
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection