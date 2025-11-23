<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Nintendo Switch', 'manufacturer' => 'Nintendo', 'notes' => 'Hybrid console.'],
            ['name' => 'PlayStation 5', 'manufacturer' => 'Sony', 'notes' => 'Next gen Sony console.'],
            ['name' => 'Xbox Series X', 'manufacturer' => 'Microsoft', 'notes' => 'Powerful Microsoft console.'],
            ['name' => 'PC', 'manufacturer' => 'Various', 'notes' => 'Windows/Steam/EPIC platform.'],
            ['name' => 'Nintendo 3DS', 'manufacturer' => 'Nintendo', 'notes' => 'Handheld legacy.'],
        ];

        foreach ($data as $row) {
            Platform::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
