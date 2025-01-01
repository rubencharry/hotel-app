<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return response()->json(['message' => 'Bienvenido al backend de la prueba técnica'], 200);
});

