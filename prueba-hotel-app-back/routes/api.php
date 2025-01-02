<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;

Route::get('/get-all-hotels', [HotelController::class, 'index']); 
Route::get('/get-hotel-by-id/{id}', [HotelController::class, 'get']);
Route::post('/create-hotel', [HotelController::class, 'create']); 
Route::put('/update-hotel/{id}', [HotelController::class, 'update']); 
Route::delete('/delete-hotel/{id}', [HotelController::class, 'delete']);

Route::get('/get-rooms/{hotelId}', [RoomController::class, 'index']);
Route::get('/get-room-by-id/{id}', [RoomController::class, 'get']);
Route::post('/create-room', [RoomController::class, 'create']);
Route::put('/update-room/{id}', [RoomController::class, 'update']);
Route::delete('/delete-room/{id}', [RoomController::class, 'delete']);

Route::get('/get-room-types', [RoomTypeController::class, 'index']); 

Route::get('/get-accommodation-by-room-type/{id}', [AccommodationController::class, 'get']);
