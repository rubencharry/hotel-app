<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Hotel;
use App\Validators\RoomValidator;
use Illuminate\Support\Facades\Validator;
use App\Models\RoomType;
use App\Models\Accommodation;

class RoomService
{
    public function getRoomsByHotel($hotelId)
    {
        return Room::where('hotel_id', $hotelId)
            ->with(['roomType', 'accommodation'])
            ->get();
    }

    public function createRoom(array $data)
    {
        $validator = Validator::make($data, [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'accommodation_id' => 'required|exists:accommodations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors(), 'status' => 422];
        }

        try {
            $hotel = Hotel::find($data['hotel_id']);

            if (!$hotel) {
                return [
                    'error' => 'Hotel do not exist.',
                    'status' => 404
                ];
            }
              
            // Validar configuración única
            RoomValidator::validateUniqueRoomConfiguration($hotel, $data['room_type_id'], $data['accommodation_id']);
            
            // Validar cantidad de habitaciones
            RoomValidator::validateRoomQuantity($hotel, $data['quantity']);
            
            return Room::create($data);
           
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function updateRoom($id, array $data)
{
    try {
        // Validar los datos entrantes
        $validator = \Validator::make($data, [
            'room_type_id' => 'required|exists:room_types,id',
            'accommodation_id' => 'required|exists:accommodations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Buscar la habitación
        $room = Room::find($id);

        if (!$room) {
            return [
                'error' => 'Room do not exist.',
                'status' => 404
            ];
        }

        $hotel = $room->hotel;

        // Validar cantidad de habitaciones
        RoomValidator::validateRoomQuantity($hotel, $data['quantity'], $id);

        // Validar configuración única
        RoomValidator::validateUniqueRoomConfiguration($hotel, $data['room_type_id'], $data['accommodation_id'], $id);

        try {
            $room->update($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo actualizar la habitación.' . $e], 500);
        }

        return $room;
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Retornar los errores de validación
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Manejar cualquier otro error inesperado
        return response()->json(['error' => 'Ocurrió un error inesperado al actualizar la habitación.' .$e], 500);
    }
}



    public function deleteRoom($id)
    {
        $room = Room::find($id);
        
        if (!$room) {
            return [
                'error' => 'Room do not exist.',
                'status' => 404
            ];
        }

        return $room->delete();
    }
}
