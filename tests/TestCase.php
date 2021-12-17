<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->actingAs($user);
        TestResponse::macro('data', function ($key) {
            // 通过  $this->original->getData() 可以获取到绑定给视图的原始数据
            return $this->original->getData()[$key];
        });
        return $this;
    }
}
