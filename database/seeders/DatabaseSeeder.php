<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Design;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Teacher
        $teacher = User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'test@example.com',
        ]);

        // Assets first
        $this->call([
            AssetSeeder::class,
        ]);

        // Classes
        $classes = SchoolClass::factory()
            ->count(5)
            ->forTeacher($teacher)
            ->create();

        // Designs per class
        foreach ($classes as $class) {
            Design::factory()
                ->count(8)
                ->create([
                    'class_id' => $class->id,
                ]);
        }

        // Optional: designs without class
        Design::factory()
            ->count(5)
            ->withoutClass()
            ->create();
    }
}
