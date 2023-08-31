@extends('layouts.app')
@section('content')
@if($isAuthor)
<main class="py-4">  
<div class="post-actions d-flex justify-content-center mt-3">
    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-secondary mr-2">編集</a>
   
    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか?');">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
</div>
@else
<div class="post-actions d-flex justify-content-center mt-3">
        <a href="{{ route('violations.create', ['post' => $post->id]) }}" class="btn btn-danger">違反報告</a>
    </div>
@endif
<div class="row justify-content-around mt-3">
      <div class="row">
        <div class="col-5 my-4">
          <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage/image/' . $post->image)}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->episode }}</p>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="row justify-content-center">
        <div class="col-md-6 ">
            <ul class="list-group">
    @if(isset($comments))
    @foreach ($comments as $comment)
                    <li class="list-group-item">
                        <p class="mb-0 text-secondary">{{ $comment->user->name }}</p>
                        <p class="mb-0 text-secondary">{{ $comment->text }}</p>
                    </li>
    @endforeach
    @endif 
                <li class="list-group-item">
                    <div class="py-3">
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <div class="form-group row mb-0">
                                
                                <div class="col-md-12">
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="3">{{ old('text') }}</textarea>

                                    @error('text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-right">
                                    <p class="mb-4 text-danger">500文字以内</p>
                                    <button type="submit" class="btn btn-primary">
                                     コメントする
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</main>

@endsection