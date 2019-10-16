<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HiQStd\Close\Listener;

use HiQStd\Close\Event\DiscussionWasUnclosed;
use HiQStd\Close\Notification\DiscussionClosedBlueprint;
use HiQStd\Close\Post\DiscussionClosedPost;
use Flarum\Notification\NotificationSyncer;

class CreatePostWhenDiscussionIsUnclosed
{
    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(DiscussionWasUnclosed $event)
    {
        $post = DiscussionClosedPost::reply(
            $event->discussion->id,
            $event->user->id,
            false
        );

        $post = $event->discussion->mergePost($post);

        if ($event->discussion->user_id !== $event->user->id) {
            $notification = new DiscussionClosedBlueprint($post);

            $this->notifications->sync($notification, $post->exists ? [$event->discussion->user] : []);
        }
    }
}
