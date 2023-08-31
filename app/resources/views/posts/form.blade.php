@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新規投稿</h1>
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" placeholder="タイトルを入力してください"/>
        </div>
        <div class="form-group">
                    <label for="image">画像 </label>
                    <div class="col-md-6">
                        <input id="image" type="file" name="image">
                    </div>
        </div>
        <div class="form-group">
            <label for="episode">本文</label>
            <textarea name="episode" id="episode" class="form-control" rows="5" value="{{old('episode')}}" placeholder="本文を入力してください"></textarea>
        </div>
        <button type="submit"  class="btn btn-primary">投稿</button>
        <button type="reset"  class="btn btn-secondary" onclick='window.history.back(-1);'>キャンセル</button>
    </form>
</div>
@endsection
        