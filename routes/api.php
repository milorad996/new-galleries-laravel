<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::get('refresh', 'refresh');
    Route::get('profile', 'getMyProfile');
});


Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/user-galleries/{id}', [GalleryController::class, 'show']);
Route::post('/galleries', [GalleryController::class, 'store']);
Route::put('/galleries/{id}', [GalleryController::class, 'update']);
Route::get('/galleries/{id}', [GalleryController::class, 'getAuthorGallery']);
Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
Route::get('/galleries-slider', [GalleryController::class, 'sliderGallery']);

Route::post('/galleries/{id}/comments', [CommentController::class, 'store']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
