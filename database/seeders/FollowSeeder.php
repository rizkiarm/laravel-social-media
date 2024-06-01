<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $statuses = ['pending', 'approved', 'rejected'];
        foreach($users as $userA){
            foreach($users as $userB){
                if(rand(0,1) < 0.8){
                    continue;
                }
                $userA->followers()->attach($userB, ['status' => $statuses[array_rand($statuses)]]);
            }   
        }
    }
}
