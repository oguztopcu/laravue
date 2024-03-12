<?php

namespace Tests\Feature;

use App\ApiUser;
use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class KeyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_key_items_for_index()
    {
        $user = User::factory()->create();
        $key1 = Key::factory()->create(['user_id' => $user->id]);
        $key2 = Key::factory()->create(['user_id' => $user->id]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->json('GET', '/api/keys', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['data'])
                 ->assertJsonCount(2, 'data')
                 ->assertJson([
                     'data' => [
                         [
                             'id' => $key2->id,
                         ],
                         [
                             'id' => $key1->id,
                         ],
                     ],
                 ]);
    }

    public function test_it_searches_for_a_key()
    {
        $user = User::factory()->create();
        $key = Key::factory()->create(['user_id' => $user->id]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->json('GET', '/api/keys/search', ['name' => $key->key], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['data']);
    }

    public function test_it_creates_or_updates_a_key_for_store()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->json('POST', '/api/keys', [
            'key' => 'new_key',
            'value' => 'new_value',
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure(['message', 'data']);

        // update value request
        $existingKey = Key::factory()->create(['user_id' => $user->id]);
        $response = $this->json('POST', '/api/keys', [
            'key' => $existingKey->key,
            'value' => 'updated_value',
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure(['message', 'data']);
    }

    public function test_it_returns_a_key_for_show()
    {
        $user = User::factory()->create();
        $key = Key::factory()->create(['user_id' => $user->id]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->json('GET', "/api/keys/{$key->id}", [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['data']);
    }

    public function test_it_deletes_a_key_for_destroy()
    {
        $user = User::factory()->create();
        $key = Key::factory()->create(['user_id' => $user->id]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->json('DELETE', "/api/keys/{$key->id}", [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure(['message']);
    }
}
