@extends('layouts.app')
@section('content')
@auth
@if (auth()->user()->role === 0)
@endif
@endauth
<div class="container text-center mt-5">
    <h1>管理者画面</h1>

    <div class="d-flex flex-column justify-content-center align-items-center vh-90">
    <a href="{{ route('violations.role') }}" class="btn btn-info mb-3">一般ユーザーのリスト</a>
    <a href="{{ route('violations.index') }}" class="btn btn-info">違反投稿のリスト</a>
</div>
</div>

@endsection