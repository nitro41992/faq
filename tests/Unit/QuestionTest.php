<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Question;

class QuestionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSave()
    {
        $user = factory(User::class)->make();
        $user->save();
        $question = factory(Question::class)->make();
        $question->user()->associate($user);
        $this->assertTrue($question->save());
    }
}
