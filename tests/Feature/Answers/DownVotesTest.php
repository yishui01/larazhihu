<?php

namespace Tests\Feature\Answers;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\VoteDownContractTest;
use Tests\TestCase;

class DownVotesTest extends TestCase
{
    use RefreshDatabase;
    use VoteDownContractTest;

    protected function getVoteDownUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/down-votes" : '/answers/1/down-votes';
    }

    protected function getCancelVoteDownUri($answer = null)
    {
        return $answer ? "/answers/{$answer->id}/cancel-down-votes" : '/answers/1/down-votes';
    }

    protected function downVotes($answer)
    {
        return $answer->refresh()->votes('vote_down')->get();
    }

    protected function getModel()
    {
        return Answer::class;
    }
}
