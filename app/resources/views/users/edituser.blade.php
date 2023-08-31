@extends('layouts.app')
@section('content')
<div class="mb-3">
<form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="name">ユーザー情報</label>
            <input name="name" id="name" class="form-control" rows="5" value="{{ Auth::user()->name}}" placeholder="本文を入力してください">
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input name="email" id="email" class="form-control" rows="5" value="{{Auth::user()->email}}" placeholder="本文を入力してください">
        </div>
<div class="form-group">
                    <label for="images">アイコン画像 </label>
                    <div class="col-md-6">
                        <input id="images" type="file" name="images">
                    </div>
        </div>
        <div class="form-group">
            <label for="profile">プロフィール</label>
            <input name="profile" id="profile" class="form-control" rows="5" value="{{Auth::user()->profile}}" placeholder="本文を入力してください">
        </div>
<button type="submit"  class="btn btn-primary">編集</button>
</form>
</div>
@endsection