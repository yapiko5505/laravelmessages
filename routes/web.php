<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;

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
})->name('top');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// お問い合わせ
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::post('message/comment/store', [CommentController::class, 'store'])->name('comment.store');

Route::get('message/mymessage', [MessageController::class, 'mymessage'])->name('message.mymessage');
Route::get('message/mycomment', [MessageController::class, 'mycomment'])->name('message.mycomment');
Route::resource('message', MessageController::class);

require __DIR__.'/auth.php';
