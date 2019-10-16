<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HiQStd\Close\Access;

use Flarum\Discussion\Discussion;
use Flarum\User\AbstractPolicy;
use Flarum\User\User;

class DiscussionPolicy extends AbstractPolicy
{
    /**
     * {@inheritdoc}
     */
    protected $model = Discussion::class;

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function delete(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function hide(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function lock(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function rename(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function reply(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function sticky(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Discussion $discussion
     * @return bool
     */
    public function tag(User $actor, Discussion $discussion) {
        return (!$discussion->is_closed) ?: false;
    }
}
