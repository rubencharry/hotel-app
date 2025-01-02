<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Hotel;
use App\Validators\RoomValidator;
use App\Models\RoomType;
use App\Models\Accommodation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomService
{
    public function getRoomsByHotel($hotelId)
    {
        return Room::where('hotel_id', $hotelId)
            ->with(['roomType', 'accommodation'])
            ->get();
    }
    
    public function getRoomById($id) {
        $room = Room::find($id);
        if (!$room) {
            return [
                'error' => 'Room do not exist.',
                'status' => 404
            ];
        }
        return $room;
    }

    public function createRoom(array $data)
    {
        try {
            $validator = \Validator::make($data, [
                'hotel_id' => 'required|exists:hotels,id',
                'room_type_id' => 'required|exists:room_types,id',
                'accommodation_id' => 'required|exists:accommodations,id',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $hotel = Hotel::find($data['hotel_id']);
            if (!$hotel) {
                return response()->json(['error' => 'Hotel no encontrado.'], 404);
            }
            RoomValidator::validateRoomTypeAndAccommodation($data['room_type_id'], $data['accommodation_id']);

            RoomValidator::validateRoomQuantity($hotel, $data['quantity']);

            RoomValidator::validateUniqueRoomConfiguration(
                $hotel,
                $data['room_type_id'],
                $data['accommodation_id']
            );

            $room = Room::create($data);

            return response()->json($room, 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error inesperado al crear la habitación.' .$e], 500);
        }
    }


    public function updateRoom($id, array $data)
    {
        try {
            $validator = \Validator::make($data, [
                'room_type_id' => 'required|exists:room_types,id',
                'accommodation_id' => 'required|exists:accommodations,id',
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $room = Room::find($id);

            if (!$room) {
                return [
                    'error' => 'Room do not exist.',
                    'status' => 404
                ];
            }

            $hotel = $room->hotel;
            
            //Validar que la combinación sea válida
            RoomValidator::validateRoomTypeAndAccommodation($data['room_type_id'], $data['accommodation_id']);

            // Validar cantidad de habitaciones
            RoomValidator::validateRoomQuantity($hotel, $data['quantity'], $id);

            // Validar configuración única
            RoomValidator::validateUniqueRoomConfiguration($hotel, $data['room_type_id'], $data['accommodation_id'], $id);

            try {
                $room->update($data);
            } catch (\Exception $e) {
                return response()->json(['error' => 'No se pudo actualizar la habitación.' . $e], 500);
            }

            return response()->json($room, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
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
