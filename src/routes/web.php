<?php

use Illuminate\Support\Facades\Route;
use admin\emails\Controllers\EmailController;

Route::name('admin.')->middleware(['web','auth:admin'])->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('emails', EmailController::class);
        Route::post('emails/updateStatus', [EmailController::class, 'updateStatus'])->name('emails.updateStatus');
    });
});
