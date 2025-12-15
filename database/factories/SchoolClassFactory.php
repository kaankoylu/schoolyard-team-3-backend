<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition(): array
    {
        $base = $this->faker->randomElement(['Groep A', 'Groep B', 'Groep C', 'Groep D']);

        return [
            'teacher_id' => User::factory(),
            // Always unique, no faker unique() needed
            'name' => $base . ' ' . strtoupper(Str::random(4)),
        ];
    }

    public function forTeacher(User $teacher): static
    {
        return $this->state(fn () => ['teacher_id' => $teacher->id]);
    }
}
