<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $storage = Storage::disk('public');
        return [
            'post_id' => null,
            'path' => str_replace($storage->path(''), '', fake()->image($storage->path('media'), 640, 480, $randomize=false)),
            'type' => fake()->randomElement(['image']),
        ];
    }
}