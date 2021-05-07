<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionsTest extends TestCase
{
    /**
     * @test
     */
    public function UserCanViewQuestions()
    {
        // 不捕获异常，直接抛出
        $this->withoutExceptionHandling();

        // 1.假设 /questions 路由存在
        // 2. 访问链接 questions
        $test = $this->get('/questions');

        // 3. 正常返回 200
        $test->assertStatus(200);
    }
}
