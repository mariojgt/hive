<?php

use Illuminate\Support\Facades\Route;
use Dsm\Peach\Controllers\HomeContoller;

// Example Controller
Route::group([
    'middleware' => ['web']
], function () {
    // Load flick example view
    Route::get('/skeleton', [HomeContoller::class , 'index'])->name('skeleton');
});
