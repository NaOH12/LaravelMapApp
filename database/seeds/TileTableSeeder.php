<?php

use Illuminate\Database\Seeder;
use App\MapApp;

class TileTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the zoom level and number of tiles
        $zoom_level = MapApp::POST_ZOOM_LEVEL;
        $size = pow(2, $zoom_level) - 1;
        // Seed tile database
        for ($counter = 0; $counter <= 10; $counter++) {
            $tile = new App\Tile;
            $x = rand(0, $size);
            $y = rand(0, $size);
            $tile->id = (pow(2, $zoom_level) * $y) + $x + 1;
            $tile->x = $x;
            $tile->y = $y;
            $tile->save();
        }
    }
}
