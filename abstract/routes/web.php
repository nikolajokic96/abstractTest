<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\LoginCredentials;
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

Route::get('/', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login'])->middleware(LoginCredentials::class);

Route::post('/upload', [FileController::class, 'uploadFile']);
