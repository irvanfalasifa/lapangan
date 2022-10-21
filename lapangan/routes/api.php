<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LapanganController;

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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::get('/lapangan', [LapanganController::class, 'lapangan']);
Route::get('/lapanganall', [LapanganController::class, 'lapanganAuth'])->middleware('jwt.verify');
Route::get('/user', [UserController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');
// Route::delete('/deleteuser/{user}', [UserController::class, 'getDeleteUser']);

// Route::post('register', 'UserController@register');
// Route::post('login', 'UserController@login');
// Route::post('logout', 'UserController@logout');
// Route::get('lapangan', 'LapanganController@lapangan');
// Route::get('lapanganall', 'LapanganController@lapanganAuth')->middleware('jwt.verify');
// Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');
