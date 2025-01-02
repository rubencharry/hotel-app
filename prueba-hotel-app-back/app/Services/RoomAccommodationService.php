<?php

namespace App\Services;

use App\Models\RoomType;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomAccommodationService
{
    public function getAccommodationByRoomTypeId($id)
    {
        try {
            $roomType = RoomType::with('accommodations')->find($id);
    
            if (!$roomType) {
                return response()->json([
                    'error' => 'Tipo de habitación no encontrado.',
                ], 404);
            }
    
            return response()->json($roomType->accommodations, 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al recuperar las acomodaciones.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    
}
