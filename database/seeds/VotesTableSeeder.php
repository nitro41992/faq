<?php

use Illuminate\Database\Seeder;
use App\Vote;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Vote::class, 100)->create()->each(function ($vote) {
        });
    }
}
