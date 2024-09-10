<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->asAdmin()->create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'admin',
            'token' => 'custom-token',
        ]);
    }
}
