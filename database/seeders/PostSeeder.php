<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Post;
use App\Models\Media;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach($users as $user){
            $user->posts()->saveMany(Post::factory(random_int(0,20))->make());
        }

        $posts = Post::all();
        foreach($posts as $post){
            if(rand(0,1) < 0.5){
                continue;
            }
            $post->update(['parent_id' => $posts->random()->id]);
        }

        $comments = Post::whereNotNull('parent_id')->get();
        foreach($posts as $post){
            if(rand(0,1) < 0.5){
                continue;
            }
            $post->update(['parent_id' => $comments->random()->id]);
        }

        $posts = Post::whereNull('parent_id')->get();
        foreach($posts as $post){
            $post->medias()->saveMany(Media::factory(random_int(0,4))->make());
        }
    }
}
