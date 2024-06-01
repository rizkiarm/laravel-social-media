<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Post;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();
        foreach($users as $user){
            foreach($posts as $post){
                if(rand(0,1) < 0.8){
                    continue;
                }
                $user->bookmarkedPosts()->attach($post);
            }   
        }
    }
}
