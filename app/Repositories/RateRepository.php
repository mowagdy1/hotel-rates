<?php

namespace App\Repositories;

use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use function PHPUnit\Framework\isEmpty;

class RateRepository
{
    public function getAllBetween($startDate, $endDate, $orderBy = null): Collection
    {
        $query = $this->buildQuery([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'order_by' => $orderBy
        ]);
        return $query->get();
    }

    public function list(array $requestBody): LengthAwarePaginator
    {
        $query = $this->buildQuery($requestBody);
        return $query->paginate(10);
    }

    public function buildQuery(array $data): Builder
    {
        $query = Rate::query()->with('hotel');

        if (isset($data['hotel_id']) && $data['hotel_id']) {
            $query->where('hotel_id', $data['hotel_id']);
        }
        if (isset($data['date']) && $data['date']) {
            $query->where('date_of_stay', $data['date']);
        }
        if (isset($data['start_date']) && isset($data['end_date']) && $data['start_date'] && $data['end_date']) {
            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
            $query->whereBetween('date_of_stay', [$startDate, $endDate]);
        }
        if (isset($data['order_by']) && $data['order_by']) {
            $query->orderBy($data['order_by']);
        }

        return $query;
    }

    public function findById($id): Rate
    {
        return Rate::findOrFail($id);
    }

    public function create(int $hotelId, Carbon $dateScraped, Carbon $dateOfStay, float $ratePerNight)
    {
        return Rate::create([
            'hotel_id' => $hotelId,
            'date_scraped' => $dateScraped,
            'date_of_stay' => $dateOfStay,
            'rate_per_night' => $ratePerNight,
        ]);
    }
}
