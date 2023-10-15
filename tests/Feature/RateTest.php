<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Hotel;
use App\Models\Rate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class RateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     * @throws Throwable
     */
    public function testIndex(): void
    {
        // Arrange
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);
        Rate::factory()->count(5)->create(['hotel_id' => $hotel->id]);

        // Act
        $response = $this->get('/api/rates');

        // Assert
        $response->assertStatus(200);
        $data = $response->decodeResponseJson();
        $this->assertCount(5, $data['data']);
    }

    /**
     * Test the listPaginated method.
     *
     * @return void
     * @throws Throwable
     */
    public function testListPaginated(): void
    {
        // Arrange
        $customer = Customer::factory()->create();
        $hotel = Hotel::factory()->create(['customer_id' => $customer->id]);
        Rate::factory()->count(15)->create(['hotel_id' => $hotel->id]);

        // Act
        $response = $this->get('/api/rates?page=2');

        // Assert
        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(5, $data['data']);

        // Assert pagination metadata
        $this->assertEquals(2, $data['meta']['current_page']);
        $this->assertEquals(10, $data['meta']['per_page']);
        $this->assertEquals(15, $data['meta']['total']);

        // Assert the links
        $this->assertEquals(url('/api/rates?page=1'), $data['links']['prev']);
        $this->assertNull($data['links']['next']);
    }
}
