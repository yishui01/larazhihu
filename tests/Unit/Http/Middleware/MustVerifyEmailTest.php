<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\MustVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MustVerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unverified_user_must_verify_email_before_do_something_not_allowed()
    {
        $this->signIn(create(User::class, [
            'email_verified_at' => null
        ]));
        $middleware = new MustVerifyEmail();
        $response = $middleware->handle(new Request, function ($request) {
            $this->fail("Next middleware was called.");
        });
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/email/verify'), $response->getTargetUrl());
    }

    /**
     * @test
     */
    public function verified_user_can_continue()
    {
        $this->be(create(User::class, [
            'email_verified_at' => Carbon::now()
        ]));
        $request = new Request();
        $middleware = new MustVerifyEmail();
        $call = false;
        $response = $middleware->handle($request, function ($request) use (&$call) {
            $call = true;
            return $request;
        });
        $this->assertEquals($call, true);
        $this->assertSame($request, $response);
    }
}
