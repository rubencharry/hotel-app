<?php

namespace App\Http\Controllers;

use App\Services\RoomAccommodationService;

use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    protected $roomAccommodationService;

    public function __construct(RoomAccommodationService $roomAccommodationService)
    {
        $this->roomAccommodationService = $roomAccommodationService;
    }

    public function get($id)
    {
        $roomTypes = $this->roomAccommodationService->getAccommodationByRoomTypeId($id);
        return response()->json($roomTypes);
    }

}