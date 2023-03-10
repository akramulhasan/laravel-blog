<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;

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

Route::get('/admin-only', function(){
  
        return 'This page only for admin users';
   
    
})->middleware('can:visitAdminPages');
// User Route
Route::get('/', [UserController::class, 'correctHomepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Blog Post Route

Route::get('/create-post', [PostController::class, 'createPostForm'])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storePost'])->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'singlePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class, 'editPost'])->middleware('can:update,post');


// Ticket Route
Route::get('/create-ticket',[TicketController::class, 'createTicketForm']);
Route::post('/create-ticket',[TicketController::class, 'storeTicket']);
Route::get('/ticket/{ticket}', [TicketController::class, 'singleTicket']);

//Follow
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow']);
Route::post('/removeto-follow/{user:username}', [FollowController::class, 'removeFollow']);

//Profile Route
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
Route::get('/manage-avatar', [UserController::class, 'manageAvatarForm'])->middleware('MustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('MustBeLoggedIn');
