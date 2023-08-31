@extends('layouts.app')
@section('content')
@auth
@if (auth()->user()->role === 1)
@endif
@endauth


<div class="main-content"> 
<div class="container">
    <div class="d-flex justify-content-between">
        <div class="text-left">
            <form method="GET" action="{{ route('posts.index') }}">
                <input type="search" name="search" value="@if (isset($search)) {{ $search }} @endif">
                <input type="date" name="from" placeholder="from_date" value="{{ old('from')}}">
                <button type="submit">検索</button>
            </form>
        </div>
</div>
</div>
<div class="container">
    <div class="d-flex justify-content-between">
    <div class="text-right">
    <a href="{{ route('users.index')}}" class="mr-2">
        <button type="button" class="btn btn-outline-info">マイページ</button>
    </a>
</div>
        <a href="{{ route('posts.create')}}">
            <button type="button" class="btn btn-info">新規投稿</button>
        </a>
    </div>
</div>

 
 
   @if(isset($posts))
    <div class="container">
        <div class="d-flex justify-content-around flex-wrap">
        @foreach ($posts->sortByDesc('created_at') as $post)
                <div class="col-md-4 my-4">
                    <div class="card" style="width: 18rem;">
                    <img src="{{ $post->image ? asset('storage/image/' . $post->image) : asset('storage/no-image.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->episode }}</p>
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                                <button type='button'class='btn btn-primary'>詳細</button>
                            </a>
                            <p class="favorite-marke">
                                @if($like_model->like_exist(Auth::user()->id, $post->id))
                                
                                    <a class="js-like-toggle loved" href="" data-postid="{{ $post->id }}"><button class="fas fa-heart">♡</button></a>
                                    
                                @else
                               
                                    <a class="js-like-toggle" href="" data-postid="{{ $post->id }}"><button class="fas fa-heart">♡</button></a>
                                @endif
                                <span class="likesCount" id="likesCount_{{ $post->id }}">{{ $post->likes_count }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
@endif
</div>

   



@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>

$(function () {
    var like = $('.js-like-toggle');
    var likePostId;

    
    
    like.on('click', function () {
        var $this = $(this);
        likePostId = $this.data('postid');

        
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/ajaxlike',  //routeの記述
                type: 'POST', //受け取り方法の記述（GETもある）
                data: {
                    'post_id': likePostId //コントローラーに渡すパラメーター
                },
        })
    
            // Ajaxリクエストが成功した場合
            .done(function (data) {
    //lovedクラスを追加
                $this.toggleClass('loved'); 
    
    //.likesCountの次の要素のhtmlを「data.postLikesCount」の値に書き換える
                $this.next('.likesCount').html(data.postLikesCount); 
                updateLikesCount(likePostId, data.postLikesCount);
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data, xhr, err) {
    //ここの処理はエラーが出た時にエラー内容をわかるようにしておく。
    //とりあえず下記のように記述しておけばエラー内容が詳しくわかります。笑
                console.log('エラー');
                console.log(err);
                console.log(xhr);
            });
           

        
        return false;

        $('.likesCount').each(function () {
        var postId = $(this).attr('id').split('_')[1];
        var $likesCountElement = $(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/ajaxlike',// このURLを適切に設定
            type: 'GET',
            data: {
                'post_id': postId
            },
        })
        .done(function (data) {
            updateLikesCount(postId, data.postLikesCount);
        })
        .fail(function (data, xhr, err) {
            console.log('エラー');
            console.log(err);
            console.log(xhr);
        });
    });
    });
});
    
</script>