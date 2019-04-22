<?php

use App\Question;
use App\User;
use App\Answer;
use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::inRandomOrder();
        $users->each(function($user){
            for ($i=1 ; $i<=6 ; $i++) {
                $question = Question::inRandomOrder()->first();
                $answer = factory(Answer::class)->make();
                $answer->user()->associate($user);
                $answer->question()->associate($question);
                $answer->save();
            }
        });
    }
}
