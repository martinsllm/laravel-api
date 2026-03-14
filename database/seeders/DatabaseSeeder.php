<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'add']);
        Permission::firstOrCreate(['name' => 'edit']);
        Permission::firstOrCreate(['name' => 'delete']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(['add', 'edit', 'delete']);

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo(['add']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory(10)->create();
        $user->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
