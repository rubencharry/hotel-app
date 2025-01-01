<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Inertia\Inertia;

Route::get('/get-all-hotels', [HotelController::class, 'index']); 
Route::post('/create-hotel', [HotelController::class, 'create']); 
Route::put('/update-hotel/{id}', [HotelController::class, 'update']); 
Route::delete('/delete-hotel/{id}', [HotelController::class, 'delete']);

Route::get('/get-rooms/{hotelId}', [RoomController::class, 'index']);
Route::post('/create-room', [RoomController::class, 'create']);
Route::put('/update-room/{id}', [RoomController::class, 'update']);
Route::delete('/delete-room/{id}', [RoomController::class, 'delete']);

