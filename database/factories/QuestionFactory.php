<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'body'  => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
    ];
});
