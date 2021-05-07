<?php

namespace Tests\Feature;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_view_questions()
    {
        // 不捕获异常，直接抛出
        $this->withoutExceptionHandling();

        // 1.假设 /questions 路由存在
        // 2. 访问链接 questions
        $test = $this->get('/questions');

        // 3. 正常返回 200
        $test->assertStatus(200);
    }

    /**
     * @test
     */
    public function user_can_view_single_question()
    {
        // 1. 创建一个问题
        $question = Question::factory()->create();
        // 2. 访问链接
        $test = $this->get('/questions/' . $question->id);
        // 3. 看到问题内容
        $test->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }
}
