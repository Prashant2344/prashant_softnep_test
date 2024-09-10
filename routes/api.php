<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);


Route::middleware('auth:api')->group( function () {
    Route::post('/posts/{post_id}/comments', [CommentController::class,'store']);
    Route::delete('comment/{id}', [CommentController::class,'delete']);
    Route::post('/posts/{post_id}/comment/{id}', [CommentController::class,'update']);
});
Route::get('comments', [CommentController::class,'index']);
Route::get('post/{post_id}/comments', [CommentController::class,'getPostComment']);
