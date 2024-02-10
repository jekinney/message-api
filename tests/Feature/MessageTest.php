<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Message;
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
            ]);;
    }
}
