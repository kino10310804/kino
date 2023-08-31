@extends('layouts.app')
@section('content')
<div class="container">
    <h1>非表示投稿のユーザー一覧</h1>
    @if (count($usersData) > 0)
        <ul>
            @foreach ($usersData as $user)
                <li>
                ユーザーID: {{ $user['id'] }},<br>
                ユーザー名: {{ $user['name'] }},<br>
                    メールアドレス: {{ $user['email'] }},
                    @if ($user['stop_count'] > 0)<br>
                        （停止投稿数: {{ $user['stop_count'] }} 件）
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>ユーザー情報が見つかりません。</p>
    @endif
</div>
@endsection