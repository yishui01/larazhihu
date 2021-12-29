<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\VoteUpContractTest;
use Tests\TestCase;

class UpVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteUpContractTest;

    protected function getVoteUpUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/up-votes" : '/answers/1/up-votes';
    }

    protected function getCancelVoteUpUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/cancel-up-votes" : '/answers/1/cancel-up-votes';
    }

    protected function upVotes($answer)
    {
        return $answer->refresh()->votes('vote_up')->get();
    }

    protected function getModel()
    {
        return Answer::class;
    }

}
