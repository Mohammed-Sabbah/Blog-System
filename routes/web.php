<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->group(function (){

    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
    Route::get('/', function () {
        return view('admin.Home');
    });

});

Route::middleware('auth')->group(function(){
    Route::get('/home' , [FrontEndController::class , 'home'] )->name('frontend.home');
    Route::post('/make_post' , [FrontEndController::class , 'make_post'] )->name('make_post');
    Route::get('/logout' , [AuthController::class , 'logout'])->name('user.logout');
    Route::post('make_comment/{post}', [CommentController::class , 'make_comment' ])->name('make_comment');
});

Route::middleware('guest')->group(function(){
    Route::get('login' , [AuthController::class , 'login'])->name('user.login');
    Route::post('login' , [AuthController::class , 'post_login'])->name('user.post_login');

});




Route::fallback(function (){
    return view('error404');
});
