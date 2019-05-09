<?php

use Illuminate\Database\Seeder;

class AnsweredQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AnsweredQuestions::class, 50)->create()->each(function ($answeredQuestions) {
        });
    }
}
