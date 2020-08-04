<?php

use Illuminate\Database\Seeder;
use App\MapApp;

class ArtPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // factory(App\Post::class, 100)->create();

        // Get zoom level
        $zoom_level = MapApp::STAMP_ZOOM_LEVEL;
        // Get max size
        $size = pow($zoom_level, 2);

        $faker = Faker\Factory::create('en_US');

        // For a set amount, generate some posts which may
        // vary in type.
        for ($count = 0; $count < 100; $count++)
        {

            // Make child text art post
            $text_post = new App\TextArtPost;
            $text_post->text_content = $faker->sentence($nbWords = 20, $variableNbWords = true);//$faker->realText(200, 1);
            $text_post->colour = 16777215;
            $text_post->font = 0;
            $text_post->size = 12.0;
            $text_post->save();

            //Get post's tile
            $tile = App\ArtTile::inRandomOrder()->first();

            // Create parent post
            $post = new App\ArtPost;
            
            $post->art_tile_id = $tile->id;
            $x = $tile->x;
            $y = $tile->y;
            $n = pow(2, $zoom_level);
            $lon_deg = $x / $n * 360.0 - 180.0;
            $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * $y / $n))));

            $post->longitude = $lon_deg;
            $post->latitude = $lat_deg;
            $post->rotation = rand(0,3600) / 10;
            $post->postable_id = 0;
            $post->postable_type = "";
            $post->user_id = App\User::inRandomOrder()->first()->id;
            $post->save();

            // Attach child to parent
            $text_post->post()->save($post);

        }

    }
}
