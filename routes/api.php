<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/books', [BookController::class, 'index']);
Route::middleware('auth:sanctum')->get('/books/{book}', [BookController::class, 'show']);
Route::middleware('auth:sanctum')->get('logout', [LoginController::class, 'logout']);

Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
