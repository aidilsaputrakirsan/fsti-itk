<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePathForDatabase = null;
        $directory = 'posts';

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $existingImages = Storage::disk('public')->files($directory);

        if (!empty($existingImages)) {
            $randomImage = Arr::random($existingImages);
            $imagePathForDatabase = $randomImage;
        }

        $title = $this->faker->sentence(mt_rand(3, 6));
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->sentence(mt_rand(10, 15)),
            'content' => $this->faker->paragraphs(mt_rand(5, 10), true),
            'post_category_id' => \App\Models\PostCategory::inRandomOrder()->first()->id ?? 1,
            'tags' => implode(',', $this->faker->words(mt_rand(2, 5))),
            'status' => $this->faker->randomElement(['Draft', 'Terbitkan']),
            'published_at' => now(),
            'image_path' => $imagePathForDatabase,
        ];
    }
}
