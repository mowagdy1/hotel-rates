<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository
{
    public function getAll(): Collection
    {
        return Customer::all();
    }

    public function getWithHotels(): Collection
    {
        return Customer::with('hotels')->get();
    }

    public function create(string $name)
    {
        return Customer::create(['name' => $name]);
    }
}
