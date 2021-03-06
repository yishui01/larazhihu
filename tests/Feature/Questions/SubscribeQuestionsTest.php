<?php

namespace Tests\Feature\Questions;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SubscribeQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_subscribe_to_or_unsubscribe_from_questions()
    {
        $this->withExceptionHandling();
        $question = create(Question::class);
        $this->post('/questions/' . $question->id . '/subscriptions')
            ->assertRedirect('/login');
        $this->delete('/questions/' . $question->id . '/subscriptions')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_user_can_subscribe_to_questions()
    {
        $this->signIn();
        $question = Question::factory()->published()->create();
        $this->post('/questions/' . $question->id . '/subscriptions');
        $this->assertCount(1, $question->subscriptions);
    }

    /**
     * @test
     */
    public function a_user_can_unsubscribe_from_questions()
    {
        $this->signIn();
        $question = Question::factory()->published()->create();

        $this->post('/questions/' . $question->id . '/subscriptions');
        $this->delete('/questions/' . $question->id . '/subscriptions');
        $this->assertCount(0, $question->subscriptions);

    }

    /**
     * @test
     */
    public function can_know_it_if_subscribed_to()
    {
        $this->signIn();

        $question = Question::factory()->published()->create();

        $this->post('/questions/' . $question->id . '/subscriptions');

        $this->assertTrue($question->refresh()->isSubscribedTo(auth()->id()));
    }

    /**
     * @test
     */
    public function can_know_subscriptions_count()
    {
        /** @var Question $question */
        $question = create(Question::class);
        $this->signIn();
        $question->subscribe(Auth::id());
        $this->assertEquals(1, $question->refresh()->subscriptions_count);
        // ??????????????????????????????
        $this->signIn(create(User::class));
        $this->post('/questions/' . $question->id . '/subscriptions');

        $this->assertEquals(2, $question->refresh()->subscriptions_count);
    }
}
