<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        Asset::truncate(); // wipe first for dev

        Asset::insert([
            [
                'slug'      => 'tree',
                'label'     => 'Boom',
                'image_url' => '/assets/tree.png',
                'width'     => 2,
                'height'    => 2,
            ],
            [
                'slug'      => 'bench',
                'label'     => 'Bankje',
                'image_url' => '/assets/bench.png',
                'width'     => 2,
                'height'    => 1,
            ],
            [
                'slug'      => 'slide',
                'label'     => 'Glijbaan',
                'image_url' => '/assets/slide.png',
                'width'     => 1,
                'height'    => 2,
            ],
            [
                'slug'      => 'sandbox',
                'label'     => 'Zandbak',
                'image_url' => '/assets/sandbox.png',
                'width'     => 2,
                'height'    => 2,
            ],
        ]);
    }
}
