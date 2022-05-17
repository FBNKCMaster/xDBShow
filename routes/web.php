<?php

use Illuminate\Support\Facades\Route;
use FBNKCMaster\xDBShow\Controllers\XDBShowController;

//Route::get('/about', function () {
//    return view('about');
//})->name('about');

Route::get('/xdbshow', [ XDBShowController::class, 'index' ])->name('admin.xdbshow');
Route::get('/xdbshow/{table}', [ XDBShowController::class, 'show' ])->name('admin.xdbshow.table');