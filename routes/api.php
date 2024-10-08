<?php

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
Route::name('v1.')->prefix('v1')->group(function () {
    Route::get('autobots', [\App\Http\Controllers\Api\UserController::class, 'index'])
        ->name('autobots.index');
    Route::get('autobots/{user:id}/posts', [\App\Http\Controllers\Api\PostController::class, 'index'])
        ->name('autobots.posts.index');
    Route::get('posts/{post:id}/comments', [\App\Http\Controllers\Api\CommentController::class, 'index'])
        ->name('posts.comments.index');
});
