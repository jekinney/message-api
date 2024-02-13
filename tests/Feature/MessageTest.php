<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

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
                        'content',
                        'created_at',
                    ],
                ],
            ]);
    }

    /**
     * Test a user can access their own messages. Even soft deleted ones.
     */
    public function test_a_user_can_see_all_own_messages(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs($user, ['*']);

        Message::factory(10)->create([
            'author_id' => $user->id,
        ]);

        $this->getJson('/api/v1/user/messages')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'author',
                        'content',
                        'created_at',
                    ],
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_create_a_new_message(): void
    {
        $this->seed();

        Sanctum::actingAs(User::where('display_name', 'Member User')->first(), ['*']);

        $this->postJson('/api/v1/message/', [
            'content' => 'Test message',
        ])->assertStatus(201)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_edit_their_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user, ['*']);

        $message = Message::factory()->create([
            'author_id' => $user->id,
            'content' => 'Test Message',
        ]);

        $this->getJson("/api/v1/message/{$message->id}")->assertStatus(200);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'content' => 'Updated Test Message',
        ])->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_not_edit_other_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user, ['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'content' => 'Test Message',
        ]);

        $this->getJson("/api/v1/message/{$message->id}")->assertStatus(403);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'content' => 'Updated Test Message',
        ])->assertStatus(403);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_admin_can_edit_other_messages(): void
    {
        $this->seed();

        $user = User::where('email', 'owner@example.com')->first();

        Sanctum::actingAs($user, ['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'content' => 'Test Message',
        ]);

        $this->getJson("/api/v1/admin/message/{$message->id}", [
            'content' => 'Updated Test Message',
        ])->assertStatus(200);

        $this->patchJson("/api/v1/message/{$message->id}", [
            'content' => 'Updated Test Message',
        ])->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_admin_can_delete_own_message(): void
    {
        $this->seed();

        $user = User::where('email', 'member@example.com')->first();

        Sanctum::actingAs($user, ['*']);

        $message = Message::factory()->create([
            'author_id' => $user->id,
            'content' => 'Test Message',
        ]);
        // Should delete message
        $this->deleteJson("/api/v1/message/{$message->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
        // Should restore the message
        $this->deleteJson("/api/v1/message/{$message->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_owner_can_delete_any_messages(): void
    {
        $this->seed();

        $user = User::where('email', 'owner@example.com')->first();

        Sanctum::actingAs($user, ['*']);

        $message = Message::factory()->create([
            'author_id' => User::factory()->create()->id,
            'content' => 'Test Message',
        ]);
        // Should delete message
        $this->deleteJson("/api/v1/message/{$message->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
        // Should restore the message
        $this->deleteJson("/api/v1/message/{$message->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
    }
}
