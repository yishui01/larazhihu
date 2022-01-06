<?php

namespace Tests\Unit;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_subscription_belongs_to_a_user()
    {
        $subscription = create(Subscription::class);
        $this->assertInstanceOf(BelongsTo::class, $subscription->user());
    }
}
