@extends('layouts.app')

@section('content')
<div class="container">
    <h1>いいね一覧</h1>
        <div class="d-flex justify-content-between flex-sm-wrap">
@if(isset($postlike))
    @foreach ($postlike as $post)
        <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage/image/'. $post->image) }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->episode }}</p>
            </div>
        </div>
    @endforeach
@endif
</div>
</div>
@endsection
