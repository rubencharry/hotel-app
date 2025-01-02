<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RoomTypeAccommodation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hotels = Hotel::factory(3)->create();

        $roomTypes = RoomType::insert([
            ['type' => 'Estándar'],
            ['type' => 'Junior'],
            ['type' => 'Suite'],
        ]);

        $roomTypeIds = RoomType::pluck('id', 'type');

        $accommodations = Accommodation::insert([
            ['type' => 'Sencilla'],
            ['type' => 'Doble'],
            ['type' => 'Triple'],
            ['type' => 'Cuádruple'],
        ]);

        $accommodationIds = Accommodation::pluck('id', 'type');

        $restrictions = [
            $roomTypeIds['Estándar'] => [
                $accommodationIds['Sencilla'],
                $accommodationIds['Doble'],
            ],
            $roomTypeIds['Junior'] => [
                $accommodationIds['Triple'],
                $accommodationIds['Cuádruple'],
            ],
            $roomTypeIds['Suite'] => [
                $accommodationIds['Sencilla'],
                $accommodationIds['Doble'],
                $accommodationIds['Triple'],
            ],
        ];

        foreach ($restrictions as $roomTypeId => $validAccommodationIds) {
            foreach ($validAccommodationIds as $accommodationId) {
                RoomTypeAccommodation::create([
                    'room_type_id' => $roomTypeId,
                    'accommodation_id' => $accommodationId,
                ]);
            }
        }

        foreach ($hotels as $hotel) {
            foreach ($restrictions as $roomTypeId => $validAccommodationIds) {
                foreach ($validAccommodationIds as $accommodationId) {
                    Room::factory()->create([
                        'hotel_id' => $hotel->id,
                        'room_type_id' => $roomTypeId,
                        'accommodation_id' => $accommodationId,
                        'quantity' => fake()->numberBetween(1, 10),
                    ]);
                }
            }
        }
    }
}
