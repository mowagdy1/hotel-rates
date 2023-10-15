<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RateController;
use Illuminate\Support\Facades\Route;


Route::get('/hotels', [HotelController::class, 'index']);

Route::get('/rates', [RateController::class, 'listPaginated']);
Route::get('/rates/all', [RateController::class, 'getAll']);
