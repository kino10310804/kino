<?php

namespace App\Http\Controllers;

use App\Violation;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::query()
        ->withCount('violations')
        ->whereHas('violations') // 違反報告がある投稿のみを取得
        ->orderBy('violations_count', 'desc')
        ->where('del_flg', '0')
        ->get();
    
       
    $post_id = auth()->user()->id;
    
    $rank = $posts->pluck('id')->search($post_id) + 1;
    
    return view('violations.violationindex', compact('posts', 'rank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $violation = new Violation; 
        $post = new Post;
        $test = $request->post;
       
    return view('violations.violation', [
        'violation' => $violation,
        'post' => $post,
        'test' => $test,
    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $violation = new Violation;
        $violation->text = $request->text;
        $violation->post_id = $request->post_id;
      
        $violation->save();
        
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function show(Violation $violation)
    {
       
    }

        
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function edit(Violation $violation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Violation $violation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $violation)
    {

        $violation->del_flg = 1;
        $violation->save();
      return redirect('/');
    }
    public function role(Request $request)
    {
        $posts = Post::where('del_flg', '1')->get();

        $usersData = [];

        foreach ($posts as $post) {
            if ($post->user) {
                $userId = $post->user->id;
                $userName = $post->user->name;
                $userEmail = $post->user->email;
        
                if (!isset($usersData[$userId])) {
                    $usersData[$userId] = [
                        'id' => $userId,
                        'name' => $userName,
                        'email' => $userEmail,
                        'stop_count' => 1,
                    ];
                } else {
                    $usersData[$userId]['stop_count']++;
                }
            }
        }

return view('violations.userindex', [
    'usersData' => $usersData,
    'posts' => $posts,
]);
    }
}
