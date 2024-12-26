<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category' , [CategoryController::class, 'index']);
Route::get('/category/{category}' , [CategoryController::class , 'show']);
Route::post('/category' , [CategoryController::class, 'store']);
Route::put('/category/{catgeory}' , [CategoryController::class , 'update']);
Route::delete('/category/{category}', [CategoryController::class , 'delete']);
Route::get('/category/{id}/posts', [CategoryController::class, 'getPosts']);


Route::get('/post' , [PostController::class , 'index']);
Route::get('/post/{post}' , [PostController::class, 'show']);
Route::post('/post' , [PostController::class , 'store']);
Route::put('/post/{post}' , [PostController::class , 'update']);
Route::delete('/post/{post}' , [PostController::class , 'delete']);