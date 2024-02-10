<?php

namespace Tests\Unit;

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AclTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_a_permission(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertTrue( $user->hasPerm('access-messages') );
    }
}
