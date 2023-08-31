@extends('layouts.app')
@section('content')
<div class="container">
    <h1>編集</h1>
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" value="{{$post['title']}}" placeholder="タイトルを入力してください"/>
        </div>
        <div class="form-group">
                    <label for="image">画像 </label>
                    <div class="col-md-6">
                        <input id="image" type="file" name="image" value="{{$post['image']}}">
                    </div>
        </div>
        <div class="form-group">
            <label for="episode">本文</label>
            <input name="episode" id="episode" class="form-control" rows="5" value="{{$post['episode']}}" placeholder="本文を入力してください">
        </div>
        <button type="submit" class="btn btn-primary" >編集</button>
        <button type="reset"  class="btn btn-secondary" onclick='window.history.back(-1);'>キャンセル</button>
    </form>
</div>

@endsection