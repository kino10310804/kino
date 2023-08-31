<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\User;
use App\Comment;
use App\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $search = $request->input('search');
    $fromDate = $request->input('from');
    
    $posts = Post::query()
        ->when($search, function ($query, $search) {
            $query->where('episode', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        })
        ->when($fromDate, function ($query, $fromDate) {
           $query->whereDate('created_at', '>=', $fromDate);
        })
        ->where('del_flg','0')->withCount('likes')->orderBy('created_at', 'desc')->get();


        $like_model = new Like;
        $likes = Post::withCount('likes')->orderBy('created_at', 'desc')->get();
     
    
            return view('home', [
                    
                'search' => $search,
                'posts' => $posts,
                'like_model' => $like_model,
                'fromDate' => $fromDate,
                'likes' => $likes,
            ]);
       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;

        $post->title = $request->title;
        $post->episode = $request->episode;
        $post->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {
        $dir = 'image';
        $jpg = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $jpg);
        $post->image = $jpg;
}    

        $post->save();
        

        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
{
    $comment = Comment::where('post_id', $post->id)->get();
    
    $user_id = Auth::id();
    
    $isAuthor = ($user_id === $post->user_id); // 投稿者かどうかを判定
    
    return view('posts.create', [
        'post' => $post,
        'comments' => $comment,
        'isAuthor' => $isAuthor, // 投稿者かどうかのフラグをビューに渡す
    ]);
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        $record = $post;

        // アップロードされたファイルがあるかどうかをチェック
        if ($request->hasFile('image')) {
            $dir = 'image';
            $jpg = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/' . $dir, $jpg);
            $record->image = $jpg; // 新しい画像がアップロードされた場合、画像名を更新
        }
        
        $record->title = $request['title'];
        $record->episode = $request['episode'];
        $record->save();
        
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts');
    }
    public function ajaxlike(Request $request)
    {
        
        $id = Auth::user()->id;
        $post_id = $request->post_id;
        $like = new Like;
        $post = Post::findOrFail($post_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $post_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('post_id', $post_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->post_id = $request->post_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $postLikesCount = $post->loadCount('likes')->likes_count;
       
        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'postLikesCount' => $postLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
    
}
