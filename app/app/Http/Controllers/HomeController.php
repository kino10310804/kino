<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $user = Auth::user();

    if ($user->role == 0) { // 0は管理者の役割を表すと仮定
        return view('roles.role'); // 管理者用のビュー
    } else {
        return redirect('/posts'); // 一般ユーザー用のビュー
    }
    }
}
