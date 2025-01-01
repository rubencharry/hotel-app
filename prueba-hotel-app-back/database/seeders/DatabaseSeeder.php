<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Accommodation;
use App\Models\Room;
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

        $accommodations = Accommodation::insert([
            ['type' => 'Sencilla'],
            ['type' => 'Doble'],
            ['type' => 'Triple'],
            ['type' => 'Cuádruple'],
        ]);

        $restrictions = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        foreach ($hotels as $hotel) {
            foreach ($restrictions as $roomType => $validAccommodations) {
                $roomTypeId = RoomType::where('type', $roomType)->value('id');
                $accommodationIds = Accommodation::whereIn('type', $validAccommodations)->pluck('id');

                foreach ($accommodationIds as $accommodationId) {
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
