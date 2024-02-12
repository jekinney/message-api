<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AclSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $acl = config('acl');

        // // Update or create permissions
        foreach ($acl['permissions'] as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                [
                    'role' => $perm['for'],
                    'is_admin' => $perm['is_admin'],
                    'description' => $perm['description'],
                    'display_name' => $perm['display_name'],
                ]
            );
        }
        // Update or create roles
        foreach ($acl['roles'] as $role) {
            $role = Role::updateOrCreate(
                ['slug' => $role['slug']],
                [
                    'is_seeded' => true,
                    'description' => $role['description'],
                    'display_name' => $role['display_name'],
                ]
            );
            // // Attach permissions to roles as needed
            if ($role->slug == 'owner') {
                $role->permissions()->sync(Permission::get());
            } elseif ($role->slug == 'member') {
                $role->permissions()->sync(Permission::where('is_admin', 0)->where('role', 'member')->get());
            } elseif ($role->slug == 'author') {
                $role->permissions()->sync(Permission::where('is_admin', 0)->where('role', 'author')->get());
            }
        }
    }
}
