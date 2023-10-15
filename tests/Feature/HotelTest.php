<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex(): void
    {
        // Arrange
        $customer = Customer::factory()->create();
        Hotel::factory()->count(5)->create(['customer_id' => $customer->id]);

        // Act
        $response = $this->get('/api/hotels');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }
}
