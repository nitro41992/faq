<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Vote;
use App\User;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    $questions = Question::all()->pluck('id')->toArray();
    $users = User::all()->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($users),
        'question_id' => $faker->randomElement($questions),
        'status' => $faker->boolean(75) ? 'up' : 'down'
    ];
});
