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

use Flarum\Discussion\Event\Saving;
use HiQStd\Close\Event\DiscussionWasClosed;
use HiQStd\Close\Event\DiscussionWasUnclosed;
use Flarum\User\AssertPermissionTrait;

class SaveClosedToDatabase
{
    use AssertPermissionTrait;

    public function handle(Saving $event)
    {
        if (isset($event->data['attributes']['isClosed'])) {
            $isClosed = (bool) $event->data['attributes']['isClosed'];
            $discussion = $event->discussion;
            $actor = $event->actor;

            $this->assertCan($actor, 'close', $discussion);

            if ((bool) $discussion->is_closed === $isClosed) {
                return;
            }

            $discussion->is_closed = $isClosed;

            $discussion->raise(
                $discussion->is_closed
                    ? new DiscussionWasClosed($discussion, $actor)
                    : new DiscussionWasUnclosed($discussion, $actor)
            );
        }
    }
}
