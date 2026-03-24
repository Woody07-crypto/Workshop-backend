<?php

use App\Http\Controllers\Api\CitaApiController;
use App\Http\Controllers\Api\HorarioApiController;
use App\Http\Controllers\Api\PacienteApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('pacientes', PacienteApiController::class);
Route::apiResource('horarios', HorarioApiController::class);
Route::apiResource('citas', CitaApiController::class);
