<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController');
    Route::resource('likes', 'LikeController');
    Route::resource('comments', 'CommentController');
    Route::resource('violations', 'ViolationController');
    Route::post('ajaxlike', 'PostController@ajaxlike')->name('posts.ajaxlike');
    Route::post('/update', [ResetPasswordController::class, 'update'])->name('update');
    Route::get('role', 'ViolationController@role')->name('violations.role');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
