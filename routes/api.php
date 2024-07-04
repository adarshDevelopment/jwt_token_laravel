<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('test', function (Request $request) {
    return response()->json(['message' => 'Hello world']);
});


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::get('/login', function () {
    return 'hello world';
});


Route::group(['middleware' => 'jwt.auth'], function () {
    // Route::group(['middleware' => 'api'], function () {


    Route::get('/guard', function () {
        try {
            return response()->json(['message' => 'test working'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
});

Route::post('jwtTest', function () {
    return response()->json(['message' => 'jwtTest working', 'success' => true], 200);
})->middleware('jwt');
