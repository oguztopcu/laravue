<?php

namespace Tests\Feature;

use App\ApiUser;
use App\Models\Api;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_api_items_for_index()
    {
        $user = User::factory()->create();
        $api = Api::factory()->create([
            'user_id' => $user->id,
            'token' => generateToken('apis', 'token')
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->json('GET', '/api/api-keys', [], [
            'Authorization' => 'Bearer ' . $api->token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['data']);
    }

    public function test_it_creates_an_api_for_store()
    {
        $user = User::factory()->create();
        $api = Api::factory()->create([
            'user_id' => $user->id,
            'token' => generateToken('apis', 'token')
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->json('POST', '/api/api-keys', [], [
            'Authorization' => 'Bearer ' . $api->token
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure(['message', 'api_key']);
    }

    public function test_it_deletes_an_api_for_destroy()
    {
        $user = User::factory()->create();
        $api = Api::factory()->create([
            'user_id' => $user->id,
            'token' => generateToken('apis', 'token')
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->json('POST', '/api/api-keys', [], [
            'Authorization' => 'Bearer ' . $api->token
        ]);

        $response = $this->json('DELETE', "/api/api-keys/{$api->id}", [], [
            'Authorization' => 'Bearer ' . $api->token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['message']);
    }
}
