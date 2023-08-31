@extends('layouts.app')
@section('content')

<main class="py-4">  
    <div class="text-left">
        <div class="col-5 my-6">
            <img src="{{ asset('storage/images/' . $user->images)}}" width="150px" height="150px" alt="...">
            <div class="user_id">
            <div>{{ Auth::user()->name }}<br>{{ Auth::user()->profile }}</div>
            </div>
            
            <br><a href="{{ route('users.edit', ['user' => Auth::user()->id])}}">
            <button type='button'class='btn btn-secondary'>ユーザー情報の編集</button>
            </a>
            @csrf
            <form action="{{ route('users.destroy', ['user' => Auth::user()->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか?');">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
    <a href="{{ route('likes.index', ['like' => Auth::user()->id]) }}" class="btn btn-primary">いいねした投稿</a>
        </div>
    </div>

    <div class="d-flex justify-content-around flex-wrap">
        
        @if(isset($posts))
            @foreach ($posts as $post)
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('storage/image/' . $post->image )}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->episode }}</p>
                    </div>
                </div>
            
            @endforeach
        @endif 
    </div>
    
</main>
@endsection
