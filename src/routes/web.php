<?php

use Illuminate\Support\Facades\Route;
use admin\emails\Controllers\EmailManagerController;

Route::name('admin.')->middleware(['web','auth:admin'])->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('emails', EmailManagerController::class);
        Route::post('emails/updateStatus', [EmailManagerController::class, 'updateStatus'])->name('emails.updateStatus');
    });
});
