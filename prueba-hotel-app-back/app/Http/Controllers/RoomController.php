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

    public function create(Request $request)
    {

        $room = $this->roomService->createRoom($request->all());
        return response()->json($room, 201);
    }

    public function update(Request $request, $id)
    {
        $room = $this->roomService->updateRoom($id, $request->all());
        return response()->json($room);
    }

    public function delete($id)
    {
        $message = $this->roomService->deleteRoom($id);
        return response()->json($message);
    }
}
