<?php

namespace Tests\Feature\Questions;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Question;

class PublishQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_publish_question()
    {
        $this->signIn();

        $question = create(Question::class, ['user_id' => auth()->id()]);

        $this->assertCount(0, Question::published()->get());

        $this->post(route('published-questions.store', ['question' => $question]))
            ->assertRedirect($question->refresh()->path());

        $this->assertCount(1, Question::published()->get());
    }

    /**
     * @test
     */
    public function guests_may_not_publish_questions()
    {
        $this->withExceptionHandling();
        $this->post((route('published-questions.store', ['question' => 1])))->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function only_the_question_creator_can_publish_it()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $question = create(Question::class, ['user_id' => auth()->id()]);

        $this->signIn(create(User::class));

        $this->postJson(route('published-questions.store', ['question' => $question]))
            ->assertStatus(403);

        $this->assertCount(0, Question::published()->get());
    }
}
