<?php

namespace Tests\Unit;

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AclTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_a_permission_assigned(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertTrue($user->hasPerm('access-messages'));
    }

    /**
     * A basic unit test example.
     */
    public function test_a_user_does_not_have_permission_assigned(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertFalse($user->hasPerm('admin-access-messages'));
    }

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_all_permissions_assigned_of_many(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertTrue($user->hasPerms(['access-messages', 'update-messages'], true));
    }

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_one_permission_assigned_of_many(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertTrue($user->hasPerms(['access-messages', 'admin-access-messages']));
    }

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_fails_permissions_check(): void
    {
        $this->seed();

        $user = User::where('display_name', 'Member User')->first();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $this->assertfalse($user->hasPerms(['access-messages', 'admin-access-messages'], true));
    }
}
