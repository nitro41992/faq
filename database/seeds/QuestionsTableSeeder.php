<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        for ($i=1 ; $i<=16 ; $i++) {
            $users->each(function($user){
    
               $question = factory(Question::class)->make();
               $question->user()->associate($user);
               $question->save();
    
            });
        }
    }
}
