<?php

namespace Database\Seeders;

use App\Repositories\CustomerRepository;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    private CustomerRepository $customerRepository;

    public function __construct()
    {
        $this->customerRepository = new CustomerRepository();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->customerRepository->create('Customer 1');
        $this->customerRepository->create('Customer 2');
        $this->customerRepository->create('Customer 3');
        $this->customerRepository->create('Customer 4');
        $this->customerRepository->create('Customer 5');
    }
}
