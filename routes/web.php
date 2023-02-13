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

// User Route
Route::get('/', [UserController::class, 'correctHomepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Blog Post Route

Route::get('/create-post', [PostController::class, 'createPostForm'])->middleware('MustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storePost'])->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'singlePost']);


// Ticket Route
Route::get('/create-ticket',[TicketController::class, 'createTicketForm']);
Route::post('/create-ticket',[TicketController::class, 'storeTicket']);
Route::get('/ticket/{ticket}', [TicketController::class, 'singleTicket']);

//Profile Route
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
