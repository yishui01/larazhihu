<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostAnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_post_an_answer_to_a_question()
    {
        $question = Question::factory()->create();
        $user = User::factory()->create();

        $response = $this->post("/questions/{$question->id}/answers", [
            'user_id' => $user->id,
            'content' => "this is an answer."
        ]);

        $response->assertStatus(201);
        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);
        $this->assertEquals(1, $question->answers()->count());
    }
}
