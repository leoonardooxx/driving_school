<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'das Silvas',
            'username' => 'admin',
            'nif' => '000000000',
            'profile' => 'admin',
            'active' => true,
            'password' => 'admin',
            'email' => 'admin@admin.com',
        ]);
    }
}
