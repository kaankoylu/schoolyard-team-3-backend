<?php

namespace Database\Factories;

use App\Models\Design;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesignFactory extends Factory
{
    protected $model = Design::class;

    public function definition(): array
    {
        $rows = 18;
        $cols = 22;

        return [
            'rows' => $rows,
            'cols' => $cols,
            'background_image' => '/the-top-view-from-above-is-a-map-of-the-city-with-town-infrastructure-vector.jpg',

            // If you want designs always linked to a class, keep this.
            // If you want some designs without a class, use ->state() in a seeder.
            'class_id' => SchoolClass::factory(),

            'student_name' => $this->faker->firstName(),

            // Stored as JSON array (you already cast placed_assets => array)
            'placed_assets' => $this->fakePlacedAssets($rows, $cols),

            'feedback' => null,
            'layout_id' => null,
            'user_id' => null,
        ];
    }

    private function fakePlacedAssets(int $rows, int $cols): array
    {
        $count = $this->faker->numberBetween(3, 18);

        $out = [];
        for ($i = 1; $i <= $count; $i++) {
            $w = $this->faker->numberBetween(1, 3);
            $h = $this->faker->numberBetween(1, 3);

            $out[] = [
                'instanceId' => $i,
                // Must exist in your assets table when seeding, otherwise validation will fail if you use API.
                // Factory creates DB rows directly, so it won't validate, but keep it realistic anyway.
                'assetId' => $this->faker->numberBetween(1, 10),
                'label' => $this->faker->randomElement(['Boom', 'Bankje', 'Glijbaan', 'Bloem', 'Struik']),
                'row' => $this->faker->numberBetween(0, max(0, $rows - $h)),
                'col' => $this->faker->numberBetween(0, max(0, $cols - $w)),
                'width' => $w,
                'height' => $h,
                'rotation' => $this->faker->randomElement([0, 90, 180, 270]),
            ];
        }

        return $out;
    }

    public function withoutClass(): static
    {
        return $this->state(fn () => ['class_id' => null]);
    }

    public function withFeedback(?string $text = null): static
    {
        return $this->state(fn () => ['feedback' => $text ?? $this->faker->sentence(10)]);
    }
}
