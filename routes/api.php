<?php

use App\Http\Controllers\TaskConstroller;
use Illuminate\Support\Facades\Route;

Route::prefix('/task')->group(function () {
    Route::get('/get', [TaskConstroller::class, 'get']);
    Route::post('/create', [TaskConstroller::class, 'create']);
    Route::post('/update', [TaskConstroller::class, 'update']);
    Route::delete('/delete', [TaskConstroller::class, 'delete']);
    Route::post('/search', [TaskConstroller::class, 'search']);
});
