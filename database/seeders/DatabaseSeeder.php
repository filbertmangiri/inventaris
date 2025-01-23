<?php

namespace Database\Seeders;

use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([PermissionSeeder::class, RoleSeeder::class, AdminSeeder::class, UserSeeder::class]);
    }
}
