<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function(){ # default redirect for guest
    return redirect()->route('home'); 
});

Route::controller(MainController::class)
    ->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/explore', 'explore')->name('explore');
        Route::post('/search', 'searchPost')->name('search.post');
        Route::get('/search/{keyword}', 'searchGet')->name('search.get');
    });

Route::controller(AuthController::class)->prefix('auth')
    ->group(function () {
        Route::get('/login', 'login')->name('login')->middleware("guest");
        Route::post('/authenticate', 'authenticate')->name('authenticate');
        Route::post('/logout', 'logout')->name('logout');
    });

Route::controller(RegistrationController::class)->name('register.')
    ->group(function () {
        Route::get('/register', 'create')->name('create')->middleware("guest");
        Route::post('/register/store', 'store')->name('store')->middleware("guest");
    });

Route::controller(PostController::class)->prefix('posts')->name('posts.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/likes', 'likes')->name('likes'); # important to put before /{post}
        Route::post('/{post}/like', 'like')->name('like');
        Route::delete('/{post}/like', 'unlike')->name('unlike');

        Route::get('/bookmarks', 'bookmarks')->name('bookmarks'); # important to put before /{post}
        Route::post('/{post}/bookmark', 'bookmark')->name('bookmark');
        Route::delete('/{post}/bookmark', 'unbookmark')->name('unbookmark');

        Route::post('/', 'store')->name('store')->can('create', App\Models\Post::class);
        Route::delete('/{post}', 'destroy')->name('destroy')->can('delete', 'post');
        Route::get('/{post}', 'show')->name('show')->withoutMiddleware(['auth'])->can('view', 'post');
    });

Route::controller(UserController::class)->prefix('users')->name('users.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/media', 'media')->name('media');
        Route::get('/{user}/followings', 'followings')->name('followings');
        Route::get('/{user}/followers', 'followers')->name('followers');
    });

Route::controller(UserController::class)->prefix('users')->name('users.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/{user}/edit', 'edit')->name('edit')->can('update', 'user');
        Route::patch('/{user}', 'update')->name('update')->can('update', 'user');
        Route::post('/{user}/follow', 'follow')->name('follow');
        Route::delete('/{user}/follow', 'unfollow')->name('unfollow');
        Route::post('/{user}/approve', 'approve')->name('approve')->can('approve', 'user');
        Route::post('/{user}/reject', 'reject')->name('reject')->can('reject', 'user');
    });

Route::resource('notifications', NotificationController::class)->middleware(['auth'])->only(['index']);