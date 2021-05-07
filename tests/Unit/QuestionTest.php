<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_question_has_many_answers()
    {
        $question = Question::factory()->create();
        Answer::factory()->create(['question_id' => $question->id]);
        $this->assertInstanceOf(HasMany::class, $question->answers());
    }
}
