<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Hive\Controllers\HiveContoller;

// Example Controller
Route::group([
    'middleware' => ['web']
], function () {
    // Load flick example view
    Route::get('/hive/update', [HiveContoller::class , 'composerUpdate'])->name('hive.update');
});
