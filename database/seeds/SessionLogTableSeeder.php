<?php

use Illuminate\Database\Seeder;

class SessionLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SessionLog::class, 500)->create();
    }
}
