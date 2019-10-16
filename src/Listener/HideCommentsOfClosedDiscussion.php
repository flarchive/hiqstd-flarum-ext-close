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

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Post\CommentPost;
use Symfony\Component\Translation\TranslatorInterface;

class HideCommentsOfClosedDiscussion
{
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function handle(Serializing $event)
    {
        if ($event->isSerializer(PostSerializer::class) && $event->model instanceof CommentPost) {
//            echo ($event->model);

//            echo (json_encode($event->model->discussion));
            if ($event->model->discussion->is_closed && ($event->actor->isGuest() || $event->model->user_id != $event->actor->id)) {

                $transTitle = $this->translator->trans('flarum-ext-close.forum.post_stream.closed_post_title');
                $transText = $this->translator->trans('flarum-ext-close.forum.post_stream.closed_post_text');
                if ($event->model->number == 1) {
                    $transTitle = $this->translator->trans('flarum-ext-close.forum.post_stream.closed_discussion_title');
                    $transText = $this->translator->trans('flarum-ext-close.forum.post_stream.closed_discussion_text');
                }

                $htmlRepresentation = '<div class="flarum-ext-close"><div class="closed_title">' . $transTitle . '</div><div class="closed_text">' . $transText . '</div></div>';
                $event->attributes['contentHtml'] = $htmlRepresentation;
            }
        }
    }
}
