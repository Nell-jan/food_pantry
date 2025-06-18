<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodItemController;

Route::get('/', [FoodItemController::class, 'index']);
Route::resource('food-items', FoodItemController::class);
