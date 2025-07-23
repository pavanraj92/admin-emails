<?php

use Illuminate\Support\Facades\Route;
use admin\emails\Controllers\EmailManagerController;

Route::name('admin.')->middleware(['web','admin.auth'])->group(function () {  
    Route::resource('emails', EmailManagerController::class);
    Route::post('emails/updateStatus', [EmailManagerController::class, 'updateStatus'])->name('emails.updateStatus');
});
