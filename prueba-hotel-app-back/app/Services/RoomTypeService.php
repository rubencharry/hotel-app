<?php

namespace App\Services;

use App\Models\RoomType;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomTypeService
{
    public function getRoomTypes()
    {
        try {
            return RoomType::all();
        } catch (\Exception $e) {
            return [
                'error' => 'Error al recuperar los datos.',
                'details' => $e->getMessage(),
                'status' => 500
            ];
        }
    }
    
}
