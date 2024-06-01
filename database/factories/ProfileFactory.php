<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $path = 'media/'.Str::random().'.png';
        Storage::disk('public')->put($path, file_get_contents("https://i.pravatar.cc/300"));
        return [
            'user_id' => null,
            'photo_path' => $path,
            'description' => fake()->paragraph(),
            'gender' => fake()->randomElement(['male', 'female']),
            'birthdate' => fake()->dateTime(),
            'location' => fake()->country(),
            'private' => fake()->boolean(),
        ];
    }
}