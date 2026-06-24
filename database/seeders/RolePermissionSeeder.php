<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminRole = Role::create(['name' => 'admin']);
        $studentRole = Role::create(['name' => 'student']);
        $mentorRole = Role::create(['name' => 'mentor']);

        $user = User::create([
            'name' => 'Admin Bicimici',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Qwerty123'),
        ]);

        $user->assignRole($adminRole);
    }
}
