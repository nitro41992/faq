<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Vote;

class VoteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSaveVote()
    {
        $user = factory(User::class)->make();
        $user->save();
        $vote = factory(Vote::class)->make();
        $vote->user()->associate($user);
        $this->assertTrue($vote->save());
    }

    public function testVotedView(){
        $user = factory(User::class)->make();
        $user->save();
        $response = $this->actingAs($user)->get('/voted');
        $response->assertStatus(200);
    }
}
