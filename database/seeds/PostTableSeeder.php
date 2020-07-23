<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 500)->create();

        $zoom_level = 6;
        $size = pow($zoom_level, 2);
        //here populates the community_user pivot table
        $posts = App\Post::get();
        //populate pivot table for each community
        foreach ($posts as $post)
        {
            // $x = floor((($post->longitude + 180) / 360) * pow(2, $zoom_level));
            // $y = floor((1 - log(tan(deg2rad($post->latitude)) + 1 / cos(deg2rad($post->latitude))) / pi()) /2 * pow(2, $zoom_level));
            // $post->dropForeign('tile_id');
            // $post->tile_id = ($y * $size) + $x;
            // $table->foreign('tile_id')->references('id')->
            //     on('tiles');
            // $post->save();

            $x = $post->tile->x;
            $y = $post->tile->y;
            $z = $post->tile->z;
            $n = pow(2, $z);
            $lon_deg = $x / $n * 360.0 - 180.0;
            $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $y / $n))));

            $post->longitude = $lon_deg;
            $post->latitude = $lat_deg;
            $post->save();

        }
    }

    /**
     * function tile2long(x,z) { return (x/Math.pow(2,z)*360-180); }

    * function tile2lat(y,z) {
    *     var n=Math.PI-2*Math.PI*y/Math.pow(2,z);
    *     return (180/Math.PI*Math.atan(0.5*(Math.exp(n)-Math.exp(-n))));
    * }
     */

    //  private function tile2long($x, $z) {
    //      return ($x / pow(2, $z) * 360-180);
    //  }

    //  private function tile2lat($y, $z) {
    //      $n = pi()-2*pi()*$y/pow(2,$z);
    //      return (180/pi()*atan(0.5*(exp($n)-exp(-$n))));
    //  }

}
