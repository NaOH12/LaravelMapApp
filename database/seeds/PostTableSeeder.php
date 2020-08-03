<?php

use Illuminate\Database\Seeder;
use App\MapApp;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 100)->create();

        // Get zoom level and max size
        $zoom_level = MapApp::POST_ZOOM_LEVEL;
        $size = pow($zoom_level, 2);

        // Get posts
        $posts = App\Post::get();

        // For each post, find an appropriate lat long for its foreign tile id.
        foreach ($posts as $post)
        {

            $x = $post->tile->x;
            $y = $post->tile->y;
            $n = pow(2, $zoom_level);
            $lon_deg = $x / $n * 360.0 - 180.0;
            $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $y / $n))));

            $post->longitude = $lon_deg;
            $post->latitude = $lat_deg;
            $post->save();

        }
    }

}
