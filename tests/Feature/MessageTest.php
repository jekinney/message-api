<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_see_messages(): void
    {
        Message::factory(10)->create();

        $this->getJson('/api/v1/messages')
        ->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'author',
                    'body',
                    'created_at'
                ]
            ]
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_create_a_new_message(): void
    {
        $this->seed();

        Sanctum::actingAs(User::where('display_name', 'Member User')->first(),['*']);

        $this->postJson("/api/v1/message/", [
            'body' => 'Test message'
        ])->assertStatus(201)
        ->assertJsonIsObject()
        ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_edit_their_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user,['*']);

        $message = Message::factory()->create([
            'author_id' => $user->id,
            'body' => 'Test Message'
        ]);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'body' => 'Updated Test Message'
        ])->assertStatus(200)
        ->assertJsonIsObject()
        ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
    }

     /**
     * A basic feature test example.
     */
    public function test_a_user_can_not_edit_other_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user,['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'body' => 'Test Message'
        ]);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'body' => 'Updated Test Message'
        ])->assertStatus(403);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_admin_can_edit_other_messages(): void
    {
        $this->seed();

        $user = User::where('email', 'owner@example.com')->first();

        Sanctum::actingAs($user,['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'body' => 'Test Message'
        ]);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'body' => 'Updated Test Message'
        ])->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_admin_can_delete_own_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user,['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'body' => 'Test Message'
        ]);
        // Should delete message
        $this->deleteJson("/api/v1/message/{$message->id}")
        ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
        // Should restore the message
        $this->deleteJson("/api/v1/message/{$message->id}")
        ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_owner_can_delete_any_messages(): void
    {
        $this->seed();

        $user = User::where('email', 'owner@example.com')->first();

        Sanctum::actingAs($user,['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'body' => 'Test Message'
        ]);
        // Should delete message
        $this->deleteJson("/api/v1/message/{$message->id}")
        ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
        // Should restore the message
        $this->deleteJson("/api/v1/message/{$message->id}")
        ->assertStatus(200)
         ->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'body',
                'created_at'
            ]
        ]);
    }
}
