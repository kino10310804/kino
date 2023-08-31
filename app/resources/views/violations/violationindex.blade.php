@extends('layouts.app')
@section('content')
<div class="container">
    <h1>違反投稿リスト</h1>
    
    <div class="d-flex justify-content-around flex-wrap">
        @if(isset($posts))
            @foreach ($posts as $index => $post)
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('storage/image/'. $post->image) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->episode }}</p>
                        <p class="card-text">順位: {{ $index + 1 }}</p>
                        <p class="card-text">違反報告数: {{ $post->violations_count }}</p>
                        <form action="{{ route('violations.destroy', ['violation' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('本当に停止しますか?');">表示停止</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection