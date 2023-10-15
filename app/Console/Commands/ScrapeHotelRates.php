<?php

namespace App\Console\Commands;

use App\Repositories\CustomerRepository;
use App\Repositories\RateRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScrapeHotelRates extends Command
{
    private CustomerRepository $customerRepository;
    private RateRepository $rateRepository;

    public function __construct()
    {
        parent::__construct();
        $this->customerRepository = new CustomerRepository();
        $this->rateRepository = new RateRepository();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:hotel-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraping hotel rates for each customer';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $customers = $this->customerRepository->getWithHotels();

        foreach ($customers as $customer) {
            foreach ($customer->hotels as $hotel) {
                for ($i = 0; $i < 365; $i++) {
                    $this->rateRepository->create(
                        $hotel->id,
                        Carbon::now(),
                        Carbon::now()->addDays($i),
                        rand(100, 200)
                    );
                }
            }
        }
    }
}
