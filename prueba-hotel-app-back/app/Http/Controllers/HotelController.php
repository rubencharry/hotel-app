<?php

namespace App\Http\Controllers;

use App\Services\HotelService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $hotels = $this->hotelService->listHotels();

        if (isset($hotels['error'])) {
            return response()->json(['error' => $hotels['error']], $hotels['status']);
        }

        return response()->json($hotels, 200);
    }

    public function get($id)
    {
        $result = $this->hotelService->getHotelById($id);

        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }

        return response()->json($result, 200);
    }

    public function create(Request $request)
    {
        $result = $this->hotelService->createHotel($request->all());

        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }

        return response()->json($result, 201);
    }

    public function update(Request $request, $id)
    {
        $result = $this->hotelService->updateHotel($id, $request->all());

        if (isset($result['error'])) {
            return response()->json($result['error'], $result['status']);
        }

        return response()->json($result, 200);
    }

    public function delete($id)
    {
        $result = $this->hotelService->deleteHotel($id);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['status']);
        }

        return response()->json($result, 200);
    }
}
