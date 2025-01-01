<?php

namespace App\Validators;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Validation\ValidationException;

class RoomValidator
{
    /**
     * Valida que la cantidad de habitaciones no exceda el máximo permitido por el hotel.
     *
     * @param Hotel $hotel
     * @param int $quantity
     * @param int|null $roomId
     * @throws ValidationException
     */
    public static function validateRoomQuantity(Hotel $hotel, int $quantity, int $roomId = null)
    {
        $totalRooms = $hotel->rooms
            ->where('id', '!=', $roomId)
            ->sum('quantity') + $quantity;

        if ($totalRooms > $hotel->max_rooms) {
            throw ValidationException::withMessages([
                'quantity' => 'La cantidad total de habitaciones excede el máximo permitido para este hotel.',
            ]);
        }
    }

    /**
     * Valida que no haya duplicidad de tipo y acomodación en el hotel.
     *
     * @param Hotel $hotel
     * @param int $roomTypeId
     * @param int $accommodationId
     * @param int|null $roomId
     * @throws ValidationException
     */
    public static function validateUniqueRoomConfiguration(
        Hotel $hotel,
        int $roomTypeId,
        int $accommodationId,
        int $roomId = null
    ) {
        
        $exists = $hotel->rooms()
        ->where('id', '!=', $roomId)
        ->where('room_type_id', $roomTypeId)
        ->where('accommodation_id', $accommodationId)
        ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'duplicate' => 'Ya existe una configuración con este tipo y acomodación para este hotel.',
                ]);
        }
    }
}
