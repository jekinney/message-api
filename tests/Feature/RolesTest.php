<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_owner_can_see_all_roles(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::where('display_name', 'Owner User')->first(),
            ['*']
        );

        $this->getJson('/api/v1/admin/roles')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                        'display_name',
                        'description',
                        'permissions_count'
                    ]
                ]
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_owner_can_see_a_role(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::where('display_name', 'Owner User')->first(),
            ['*']
        );

        $role = Role::first();

        $this->getJson("/api/v1/admin/role/{$role->id}")
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'slug',
                    'display_name',
                    'description',
                    'users',
                    'permissions'
                ]
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_owner_can_create_a_role(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::where('display_name', 'Owner User')->first(),
            ['*']
        );

        $users = User::factory(2)->create()->pluck('id')->toArray();
        $permissions = Permission::get('id')->pluck('id')->toArray();

        $this->postJson("/api/v1/admin/role/", [
                'slug' => 'test',
                'display_name' => 'Test Role',
                'description' => 'Test Description',
                'users' => $users,
                'permissions' => $permissions
        ])->assertStatus(201)
           ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'slug',
                    'display_name',
                    'description',
                    'users',
                    'permissions'
                ]
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_owner_can_update_a_role(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::where('display_name', 'Owner User')->first(),
            ['*']
        );

        $role = Role::factory()->create();

        $users = User::factory(2)->create()->pluck('id')->toArray();

        $permissions = Permission::get('id')->pluck('id')->toArray();

        $this->patchJson("/api/v1/admin/role/{$role->id}", [
                'slug' => 'test',
                'display_name' => 'Test Role',
                'description' => 'Test Description',
                'users' => $users,
                'permissions' => $permissions
        ])->assertStatus(200)
           ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'slug',
                    'display_name',
                    'description',
                    'users',
                    'permissions'
                ]
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_owner_update_a_role_error(): void
    {
        $this->seed();

        Sanctum::actingAs(
            User::where('display_name', 'Owner User')->first(),
            ['*']
        );

        $users = User::factory(2)->create()->pluck('id')->toArray();
        $permissions = Permission::get('id')->pluck('id')->toArray();

        $role = Role::factory()->create([
                'slug' => 'test',
                'display_name' => 'Test Role',
                'description' => 'Test Description',
            ]);

        $this->patchJson("/api/v1/admin/role/{$role->id}", [
                'slug' => 'test',
                'display_name' => 'Test Role',
                'description' => 'Test Description',
                'users' => $users,
                'permissions' => $permissions
        ])->assertStatus(422);
    }
}
