<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AclSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();
        $roles = Role::get();

        $owner = User::factory()->create([
            'display_name' => 'Owner User',
            'email' => 'owner@example.com',
        ]);

        $owner->roles()->attach($roles->where('slug', 'owner')->first());

        $member = User::factory()->create([
            'display_name' => 'Member User',
            'email' => 'member@example.com',
        ]);

        $member->roles()->attach($roles->where('slug', 'member')->first());
    }
}
