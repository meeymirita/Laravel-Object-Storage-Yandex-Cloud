<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('files')->group(function () {
    Route::get('/', [ImageController::class, 'index']);
    Route::post('/upload',[ImageController::class, 'upload']);

//    Route::delete('/delete', function () {});
});