<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(TileTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(SessionLogTableSeeder::class);
        $this->call(ArtTileTableSeeder::class);
        $this->call(ArtPostTableSeeder::class);
    }
}
