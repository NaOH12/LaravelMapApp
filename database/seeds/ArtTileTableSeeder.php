<?php

use Illuminate\Database\Seeder;
use App\MapApp;
use App\Tile;

class ArtTileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Get zoom levels
        $zoom_level = MapApp::STAMP_ZOOM_LEVEL;
        $parent_zoom_level = MapApp::POST_ZOOM_LEVEL;
        $size = pow(2, $zoom_level) - 1;

        $parent_tiles = Tile::get();

        // Seed tile database
        foreach ($parent_tiles as $parent_tile) {

            // Convert the parents tile coords to long and lat
            $n = pow(2, $parent_zoom_level);
            $lon = $parent_tile->x / $n * 360.0 - 180.0;
            $lat = rad2deg(atan(sinh(pi() * (1 - 2 * $parent_tile->y / $n))));

            // Convert the long and lat to tile coords of different zoom
            $x = floor((($lon + 180) / 360) * pow(2, $zoom_level));
            $y = floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) /2 * pow(2, $zoom_level));

            // Create the sub tile
            $art_tile = new App\ArtTile;
            $art_tile->id = (pow(2, $zoom_level) * $y) + $x + 1;
            $art_tile->x = $x;
            $art_tile->y = $y;
            $art_tile->tile_id = $parent_tile->id;
            $art_tile->save();
            
        }
    }
}
