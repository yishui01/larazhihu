<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\YouWereMentionedInComment;
use App\Providers\PostComment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

trait AddCommentContractTest
{
    /**
     * @test
     */
    public function a_notification_is_sent_when_a_comment_is_added()
    {
        Notification::fake();
        $john = create(User::class, [
            'name' => 'John'
        ]);
        $model = $this->getCommentModel();
        $model->comment("@John Thank you", $john);
        Notification::assertSentTo($john, YouWereMentionedInComment::class);
    }

    public function an_event_is_dispatched_when_a_comment_is_added()
    {
        Event::fake();

        $user = create(User::class);

        $model = $this->getCommentModel();

        $model->comment('it is a content', $user);

        Event::assertDispatched(PostComment::class);
    }

    abstract protected function getCommentModel();
}
