<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $platformMap = Platform::pluck('id', 'name')->all();

        $games = [
            ['title' => 'The Legend of Zelda: Breath of the Wild', 'genre' => 'Action-adventure', 'release_year' => 2017, 'platform' => 'Nintendo Switch', 'description' => 'Open world Zelda.'],
            ['title' => 'God of War', 'genre' => 'Action', 'release_year' => 2018, 'platform' => 'PlayStation 5', 'description' => 'Norse mythology epic.'],
            ['title' => 'Forza Horizon 5', 'genre' => 'Racing', 'release_year' => 2021, 'platform' => 'Xbox Series X', 'description' => 'Open world racing.'],
            ['title' => 'Stardew Valley', 'genre' => 'Simulation', 'release_year' => 2016, 'platform' => 'PC', 'description' => 'Farming sim indie.'],
            ['title' => 'Pokemon X', 'genre' => 'RPG', 'release_year' => 2013, 'platform' => 'Nintendo 3DS', 'description' => 'Handheld Pokemon title.'],
        ];

        foreach ($games as $g) {
            Game::updateOrCreate(
                ['title' => $g['title']],
                [
                    'genre' => $g['genre'],
                    'release_year' => $g['release_year'],
                    'platform_id' => $platformMap[$g['platform']] ?? null,
                    'description' => $g['description'],
                ]
            );
        }
    }
}
