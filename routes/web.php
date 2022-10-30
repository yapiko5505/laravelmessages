<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// Route::get('/dashboard', function () {
    // return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// お問い合わせ
Route::controller(ContactController::class)->group(function(){

    Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create')->middleware('guest');
    Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
    
});


// ログイン後の通常のユーザー画面
Route::middleware(['verified'])->group(function(){

    Route::post('message/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::get('mymessage', [MessageController::class, 'mymessage'])->name('message.mymessage');
    Route::get('mycomment', [MessageController::class, 'mycomment'])->name('message.mycomment');
    Route::resource('message', MessageController::class);

    // プロフィール編集用
    Route::get('profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    //管理者用場面
    Route::middleware(['can:admin'])->group(function(){
    Route::get('profile/index', [ProfileController::class, 'index'])->name('profile.index');
});

});











