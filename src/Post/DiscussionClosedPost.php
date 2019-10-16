<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HiQStd\Close\Post;

use Flarum\Post\AbstractEventPost;
use Flarum\Post\MergeableInterface;
use Flarum\Post\Post;

class DiscussionClosedPost extends AbstractEventPost implements MergeableInterface
{
    /**
     * {@inheritdoc}
     */
    public static $type = 'discussionClosed';

    /**
     * {@inheritdoc}
     */
    public function saveAfter(Post $previous = null)
    {
        // If the previous post is another 'discussion closed' post, and it's
        // by the same user, then we can merge this post into it. If we find
        // that we've in fact reverted the closed status, delete it. Otherwise,
        // update its content.
        if ($previous instanceof static && $this->user_id === $previous->user_id) {
            if ($previous->content['closed'] != $this->content['closed']) {
                $previous->delete();
            } else {
                $previous->content = $this->content;

                $previous->save();
            }

            return $previous;
        }

        $this->save();

        return $this;
    }

    /**
     * Create a new instance in reply to a discussion.
     *
     * @param int $discussionId
     * @param int $userId
     * @param bool $isClosed
     * @return static
     */
    public static function reply($discussionId, $userId, $isClosed)
    {
        $post = new static;

        $post->content = static::buildContent($isClosed);
        $post->created_at = time();
        $post->discussion_id = $discussionId;
        $post->user_id = $userId;

        return $post;
    }

    /**
     * Build the content attribute.
     *
     * @param bool $isClosed Whether or not the discussion is closed.
     * @return array
     */
    public static function buildContent($isClosed)
    {
        return ['closed' => (bool) $isClosed];
    }
}
