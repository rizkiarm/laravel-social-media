<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $test = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'username' => 'test',
            'password' => 'test',
        ]);

        $john = User::create([
            'name' => 'John Smith',
            'email' => 'john@test.com',
            'username' => 'john',
            'password' => 'test',
        ]);

        $users = User::factory(10)->create();
    }
}
