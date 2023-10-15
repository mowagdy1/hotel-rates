<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatesListingAllRequest;
use App\Http\Requests\RatesListingPaginatedRequest;
use App\Http\Resources\RateCollection;
use App\Http\Resources\RateResource;
use App\Repositories\RateRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class RateController extends Controller
{
    public function getAll(RatesListingAllRequest $request,
                           RateRepository         $rateRepository): JsonResponse
    {
        $startDate = $request->get('start_date', Carbon::now()->toDateString());
        $endDate = Carbon::parse($startDate)->addDays(364)->toDateString();
        $orderBy = 'date_of_stay';

        $rates = $rateRepository->getAllBetween($startDate, $endDate, $orderBy);
        $response = RateResource::collection($rates);
        return response()->json($response);
    }

    public function listPaginated(RatesListingPaginatedRequest $request,
                                  RateRepository               $rateRepository): JsonResponse
    {
        $requestBody = $request->validated();
        $paginatedRates = $rateRepository->list($requestBody);

        $response = new RateCollection($paginatedRates);
        return response()->json($response);
    }
}
