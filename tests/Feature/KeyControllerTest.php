<?php

namespace Tests\Feature\Controllers\Keys;

use App\ApiUser;
use App\Models\Key;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeyControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = User::factory()->create();

        $key = Key::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->get('/api/keys');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['id' => $key->id, 'user_id' => $user->id, 'key' => $key->key, 'value' => $key->value]
                ]
            ]);
    }

    // public function testSearch()
    // {
    //     $user = factory(ApiUser::class)->create();
    //     $key = factory(Key::class)->create(['user_id' => $user->id]);

    //     $response = $this->actingAs($user, 'api')
    //         ->get('/api/keys/search', ['name' => $key->key]);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'data' => ['id' => $key->id, 'user_id' => $user->id, 'key' => $key->key, 'value' => $key->value]
    //         ]);

    //     $response = $this->actingAs($user, 'api')
    //         ->get('/api/keys/search', ['name' => 'nonexistent_key']);

    //     $response->assertStatus(204);
    // }

    // public function testStore()
    // {
    //     $user = factory(ApiUser::class)->create();
    //     $keyData = ['key' => 'test_key', 'value' => 'test_value'];

    //     $response = $this->actingAs($user, 'api')
    //         ->post('/api/keys', $keyData);

    //     $response->assertStatus(201)
    //         ->assertJson([
    //             'message' => trans('key.success.created'),
    //             'data' => $keyData
    //         ]);

    //     $this->assertDatabaseHas('keys', [
    //         'user_id' => $user->id,
    //         'key' => $keyData['key'],
    //         'value' => $keyData['value']
    //     ]);

    //     $response = $this->actingAs($user, 'api')
    //         ->post('/api/keys', $keyData);

    //     $response->assertStatus(201)
    //         ->assertJson([
    //             'message' => trans('key.success.created'),
    //             'data' => $keyData
    //         ]);

    //     $this->assertEquals(1, Key::where('user_id', $user->id)->where('key', $keyData['key'])->count());
    // }

    // public function testShow()
    // {
    //     $user = factory(ApiUser::class)->create();
    //     $key = factory(Key::class)->create(['user_id' => $user->id]);

    //     $response = $this->actingAs($user, 'api')
    //         ->get("/api/keys/{$key->id}");

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'data' => ['id' => $key->id, 'user_id' => $user->id, 'key' => $key->key, 'value' => $key->value]
    //         ]);
    // }

    // public function testDestroy()
    // {
    //     $user = factory(ApiUser::class)->create();
    //     $key = factory(Key::class)->create(['user_id' => $user->id]);

    //     $response = $this->actingAs($user, 'api')
    //         ->delete("/api/keys/{$key->id}");

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'message' => trans('key.success.deleted')
    //         ]);

    //     $this->assertDatabaseMissing('keys', ['id' => $key->id]);
    // }
}
