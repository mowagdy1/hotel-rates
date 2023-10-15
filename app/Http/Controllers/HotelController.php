<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Repositories\HotelRepository;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function index(HotelRepository $hotelRepository): JsonResponse
    {
        $hotels = $hotelRepository->getAll();
        $response = HotelResource::collection($hotels);
        return response()->json($response);
    }
}
