<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GaleriController;

Route::apiResource('guru', GuruController::class);
Route::apiResource('galeri', GaleriController::class);

