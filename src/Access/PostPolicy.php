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

use Flarum\Post\Post;
use Flarum\User\AbstractPolicy;
use Flarum\User\User;

class PostPolicy extends AbstractPolicy
{
    /**
     * {@inheritdoc}
     */
    protected $model = Post::class;

    /**
     * @param User $actor
     * @param Post $post
     * @return bool
     */
    public function edit(User $actor, Post $post) {
        return ($post->duscussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Post $post
     * @return bool
     */
    public function delete(User $actor, Post $post) {
        return ($post->duscussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Post $post
     * @return bool
     */
    public function flag(User $actor, Post $post) {
        return ($post->duscussion->is_closed) ?: false;
    }

    /**
     * @param User $actor
     * @param Post $post
     * @return bool
     */
    public function like(User $actor, Post $post) {
        return ($post->duscussion->is_closed) ?: false;
    }
}