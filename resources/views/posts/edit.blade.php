@extends('layouts.app', ['title' => 'Update Post'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Update Post : {{ $post->title }}
                </div>
                <div class="card-body">
                    <form action="/posts/edit/{{ $post->slug }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        @include('posts.partials.form-control')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection