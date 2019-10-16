<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HiQStd\Close\Event;

use Flarum\Discussion\Discussion;
use Flarum\User\User;

class DiscussionWasClosed
{
    /**
     * @var Discussion
     */
    public $discussion;

    /**
     * @var User
     */
    public $user;

    /**
     * @param Discussion $discussion
     * @param User $user
     */
    public function __construct(Discussion $discussion, User $user)
    {
        $this->discussion = $discussion;
        $this->user = $user;
    }
}
