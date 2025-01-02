<?php

namespace App\Http\Controllers;

use App\Services\RoomService;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index($hotelId)
    {
        $rooms = $this->roomService->getRoomsByHotel($hotelId);
        return response()->json($rooms);
    }

    public function get($id)
    {
        $room = $this->roomService->getRoomById($id);
        return response()->json($room);
    }

    public function create(Request $request)
    {
        return $this->roomService->createRoom($request->all());
    }

    public function update(Request $request, $id)
    {
        return $room;
    }

    public function delete($id)
    {
        $message = $this->roomService->deleteRoom($id);
        return response()->json($message);
    }
}
