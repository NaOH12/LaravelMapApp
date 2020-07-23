<?php

use Illuminate\Database\Seeder;

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
        $zoom_level = 6;
        $size = pow(2, $zoom_level) - 1;
        // Seed tile database
        for ($y = 0; $y <= $size; $y++) {
            for ($x = 0; $x <= $size; $x++) {
                $tile = new App\Tile;
                $tile->x = $x;
                $tile->y = $y;
                $tile->z = $zoom_level;
                $tile->save();
            }
        }
    }
}
