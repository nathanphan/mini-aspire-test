<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RepayLoanController;

Route::group(['middleware' => 'auth'], function() {
    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/applications', [ApplicationController::class, 'store']);
    Route::get('/applications/{application}', [ApplicationController::class, 'show']);

    Route::post('/applications/{application}/repay', [RepayLoanController::class, 'repay']);
});

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
