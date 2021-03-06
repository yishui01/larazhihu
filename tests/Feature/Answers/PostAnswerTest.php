<?php

namespace Tests\Feature\Answers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostAnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function signed_in_user_can_post_an_answer_to_a_published_question()
    {
        /** @var Question $question */
        $question = Question::factory()->published()->create();
        $this->actingAs($user = User::factory()->create());
        $response = $this->post("/questions/{$question->id}/answers", [
            'content' => "this is an answer."
        ]);

        $response->assertStatus(302);
        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);
        $this->assertEquals(1, $question->answers()->count());
    }

    /**
     * @test
     */
    public function guest_may_not_post_an_answer()
    {
        $this->expectException(AuthenticationException::class);
        $question = Question::factory()->published()->create();
        $response = $this->post("/questions/{$question->id}/answers", [
            'content' => 'This is an answer'
        ]);
    }

    /**
     * @test
     */
    public function user_can_not_post_an_answer_to_an_unpublished_question()
    {
        $question = Question::factory()->unpublished()->create();
        $this->actingAs($user = User::factory()->create());

        $response = $this->withExceptionHandling()
            ->post("/questions/{$question->id}/answers", [
                'user_id' => $user->id,
                'content' => 'This is an answer.'
            ]);

        $response->assertStatus(404);

        $this->assertDatabaseMissing('answers', ['question_id' => $question->id]);
        $this->assertEquals(0, $question->answers()->count());

    }
//

    /**
     * @test
     */
    public function content_is_required_to_post_answers()
    {
        $this->withExceptionHandling();
        $question = Question::factory()->published()->create();
        $this->actingAs($user = User::factory()->create());

        $response = $this->post("/questions/{$question->id}/answers", [
            'user_id' => $user->id,
            'content' => null,
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }


}
