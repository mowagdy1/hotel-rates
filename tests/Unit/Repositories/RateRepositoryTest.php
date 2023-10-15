<?php

namespace Tests\Unit\Repositories;

use App\Models\Customer;
use App\Models\Hotel;
use App\Models\Rate;
use App\Repositories\RateRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected RateRepository $rateRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rateRepository = new RateRepository();
    }

    public function testGetAllBetween()
    {
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);
        Rate::factory()->count(5)->create([
            'hotel_id' => $hotel->id,
            'date_of_stay' => Carbon::today()->addDays(5)
        ]);

        $startDate = Carbon::today()->addDays(3);
        $endDate = Carbon::today()->addDays(7);
        $rates = $this->rateRepository->getAllBetween($startDate, $endDate);

        $this->assertCount(5, $rates);
    }

    public function testList()
    {
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);
        Rate::factory()->count(15)->create(['hotel_id' => $hotel->id]);

        $listedRates = $this->rateRepository->list([]);

        $this->assertCount(10, $listedRates); // because default limit is 10
    }

    public function testBuildQuery()
    {
        $customer = Customer::factory()->create();
        $hotel1 = Hotel::factory()->create(['customer_id' => $customer->id]);
        $hotel2 = Hotel::factory()->create(['customer_id' => $customer->id]);
        Rate::factory()->count(5)->create(['hotel_id' => $hotel1->id]);
        Rate::factory()->count(3)->create(['hotel_id' => $hotel2->id]);

        $query = $this->rateRepository->buildQuery(['hotel_id' => $hotel1->id]);
        $rates = $query->get();

        $this->assertCount(5, $rates);
    }

    public function testFindById()
    {
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);
        $rate = Rate::factory()->create(['hotel_id' => $hotel->id]);

        $foundRate = $this->rateRepository->findById($rate->id);

        $this->assertEquals($rate->id, $foundRate->id);
    }

    public function testCreate()
    {
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);

        $dateScraped = Carbon::today();
        $dateOfStay = Carbon::today()->addDays(10);
        $createdRate = $this->rateRepository->create($hotel->id, $dateScraped, $dateOfStay, 150.0);

        $this->assertEquals($hotel->id, $createdRate->hotel_id);
        $this->assertEquals($dateScraped, $createdRate->date_scraped);
        $this->assertEquals($dateOfStay, $createdRate->date_of_stay);
        $this->assertEquals(150.0, $createdRate->rate_per_night);
    }
}
