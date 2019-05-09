<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\AnsweredQuestions;
use App\Answer;
use App\User;
use Faker\Generator as Faker;

$factory->define(AnsweredQuestions::class, function (Faker $faker) {
    
    $answers = Answer::all()
    ->pluck('id')
    ->toArray();


    $users = User::all()
    ->pluck('id')
    ->toArray();

    return [
        'answer_id' => $faker->randomElement($answers),
        'user_id' => $faker->randomElement($users),
    ];
});
