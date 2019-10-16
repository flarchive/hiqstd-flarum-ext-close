<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HiQStd\Close\Notification;

use Flarum\Discussion\Discussion;
use HiQStd\Close\Post\DiscussionClosedPost;
use Flarum\Notification\Blueprint\BlueprintInterface;

class DiscussionClosedBlueprint implements BlueprintInterface
{
    /**
     * @var DiscussionClosedPost
     */
    protected $post;

    /**
     * @param DiscussionClosedPost $post
     */
    public function __construct(DiscussionClosedPost $post)
    {
        $this->post = $post;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromUser()
    {
        return $this->post->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->post->discussion;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return ['postNumber' => (int) $this->post->number];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'discussionClosed';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Discussion::class;
    }
}
