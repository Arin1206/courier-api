<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourierTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_courier_list()
    {
        Courier::factory()->count(3)->create();

        $response = $this->getJson('/api/couriers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_courier()
    {
        $payload = [
            'name' => 'J&T Express',
            'email' => 'jnt@test.com',
            'phone' => '08999999999',
            'level' => 3,
            'registered_at' => now()->toDateString(),
            'is_active' => true,
        ];

        $response = $this->postJson('/api/couriers', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('couriers', [
            'email' => 'jnt@test.com'
        ]);
    }

    public function test_can_show_courier()
    {
        $courier = Courier::factory()->create();

        $response = $this->getJson("/api/couriers/{$courier->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $courier->id
            ]);
    }

    public function test_can_update_courier()
    {
        $courier = Courier::factory()->create();

        $payload = [
            'name' => 'Updated Courier',
            'email' => 'updated@test.com',
            'phone' => '08123456789',
            'level' => 5,
            'registered_at' => now()->toDateString(),
            'is_active' => true,
        ];

        $response = $this->putJson("/api/couriers/{$courier->id}", $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'name' => 'Updated Courier'
        ]);
    }

    public function test_can_delete_courier()
    {
        $courier = Courier::factory()->create();

        $response = $this->deleteJson("/api/couriers/{$courier->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('couriers', [
            'id' => $courier->id
        ]);
    }

    public function test_can_search_courier()
    {
        Courier::factory()->create([
            'name' => 'Budiono Hadi Agung'
        ]);

        Courier::factory()->create([
            'name' => 'J&T Express'
        ]);

        $response = $this->getJson('/api/couriers?search=budi+agung');

        $response->assertStatus(200)
            ->assertSee('Budiono Hadi Agung');
    }

    public function test_can_filter_by_level()
    {
        Courier::factory()->create([
            'level' => 2
        ]);

        Courier::factory()->create([
            'level' => 5
        ]);

        $response = $this->getJson('/api/couriers?level=2');

        $response->assertStatus(200);
    }

    public function test_can_sort_by_registered_at()
    {
        Courier::factory()->create([
            'registered_at' => '2024-01-01'
        ]);

        Courier::factory()->create([
            'registered_at' => '2025-01-01'
        ]);

        $response = $this->getJson('/api/couriers?sort=registered_at');

        $response->assertStatus(200);
    }

    public function test_validation_error_when_required_fields_missing()
    {
        $response = $this->postJson('/api/couriers', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'email',
                'phone',
                'level',
                'registered_at'
            ]);
    }
}
