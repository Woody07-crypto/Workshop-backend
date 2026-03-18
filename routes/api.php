<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;


Route::post('/appointments', [AppointmentController::class, 'store']);