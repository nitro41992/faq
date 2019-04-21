<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSave()
    {
        $user = factory(User::class)->make();
        $this->assertTrue($user->save());
    }

    public function testQuestions()
    {
        $user = factory(User::class)->make();
        $this->assertTrue(is_object($user->questions()->get()));
    }
}
