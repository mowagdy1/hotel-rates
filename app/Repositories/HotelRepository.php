<?php

namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;

class HotelRepository
{
    public function getAll(): Collection
    {
        return Hotel::all();
    }

    public function findById($id): Hotel
    {
        return Hotel::findOrFail($id);
    }

    public function createMany(array $hotels): void
    {
        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
