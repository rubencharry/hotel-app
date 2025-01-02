<?php

namespace App\Http\Controllers;

use App\Services\RoomTypeService;

use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    protected $roomTypeService;

    public function __construct(RoomTypeService $roomTypeService)
    {
        $this->roomTypeService = $roomTypeService;
    }

    public function index()
    {
        $roomTypes = $this->roomTypeService->getRoomTypes();
        return response()->json($roomTypes);
    }

}