<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;

class HotelService
{
    public function listHotels()
    {
        try {
            return Hotel::all();
        } catch (\Exception $e) {
            return [
                'error' => 'Error al recuperar los datos.',
                'details' => $e->getMessage(),
                'status' => 500
            ];
        }
    }


    public function createHotel($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|unique:hotels,name',
            'address' => 'required',
            'city' => 'required',
            'nit' => 'required|unique:hotels,nit',
            'max_rooms' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 422];
        }

        return Hotel::create($data);
    }

    public function updateHotel($id, $data)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return [
                'error' => 'Hotel do not exist.',
                'status' => 404
            ];
        }

        $validator = Validator::make($data, [
            'name' => 'sometimes|unique:hotels,name,' . $hotel->id,
            'address' => 'sometimes',
            'city' => 'sometimes',
            'nit' => 'sometimes|unique:hotels,nit,' . $hotel->id,
            'max_rooms' => 'sometimes|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 422];
        }

        $hotel->update($data);
        return $hotel;
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::find($id);
    
        if (!$hotel) {
            return [
                'error' => 'Hotel do not exist.',
                'status' => 404
            ];
        }
        
        return $hotel->delete();
        
    }
    
}
