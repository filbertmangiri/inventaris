<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Customer')->first();

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'department' => 'Umum',
        ]);

        $user->assignRole($role);
    }
}
