<?php

namespace Database\Seeders;

use App\Repositories\CustomerRepository;
use App\Repositories\HotelRepository;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    private CustomerRepository $customerRepository;
    private HotelRepository $hotelRepository;

    public function __construct()
    {
        $this->customerRepository = new CustomerRepository();
        $this->hotelRepository = new HotelRepository();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = $this->customerRepository->getAll();

        if ($customers->count() === 0) {
            $this->command->info('No customers found. Please seed some data in customers table first.');
            return;
        }

        foreach ($customers as $customer) {
            $this->hotelRepository->createMany([
                ['name' => "Hotel A for $customer->name", 'customer_id' => $customer->id],
                ['name' => "Hotel B for $customer->name", 'customer_id' => $customer->id],
                ['name' => "Hotel C for $customer->name", 'customer_id' => $customer->id],
                ['name' => "Hotel D for $customer->name", 'customer_id' => $customer->id],
            ]);
        }
    }
}
