<?php

/*
 * This file is part of hiqstd/flarum-ext-close.
 *
 * Copyright (c) 2019 vetosers.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace HiQStd\Close;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\BasicDiscussionSerializer;
use Flarum\Discussion\Event\Saving;
use Flarum\Event\ConfigureDiscussionGambits;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Event\ConfigurePostTypes;
use Flarum\Extend;
use HiQStd\Close\Access\DiscussionPolicy;
use HiQStd\Close\Access\PostPolicy;
use HiQStd\Close\Event\DiscussionWasClosed;
use HiQStd\Close\Event\DiscussionWasUnclosed;
use HiQStd\Close\Gambit\ClosedGambit;
use HiQStd\Close\Listener\AddDiscussionClosedAttributes;
use HiQStd\Close\Listener\CreatePostWhenDiscussionIsClosed;
use HiQStd\Close\Listener\CreatePostWhenDiscussionIsUnclosed;
use HiQStd\Close\Listener\HideCommentsOfClosedDiscussion;
use HiQStd\Close\Listener\SaveClosedToDatabase;
use HiQStd\Close\Notification\DiscussionClosedBlueprint;
use HiQStd\Close\Post\DiscussionClosedPost;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    function (Dispatcher $events) {
        $events->listen(ConfigureDiscussionGambits::class, function (ConfigureDiscussionGambits $event) {
            $event->gambits->add(ClosedGambit::class);
        });
        $events->listen(Serializing::class, AddDiscussionClosedAttributes::class);
        $events->listen(Saving::class, SaveClosedToDatabase::class);

        $events->listen(ConfigurePostTypes::class, function (ConfigurePostTypes $event) {
            $event->add(DiscussionClosedPost::class);
        });
        $events->listen(ConfigureNotificationTypes::class, function (ConfigureNotificationTypes $event) {
            $event->add(DiscussionClosedBlueprint::class, BasicDiscussionSerializer::class, ['alert']);
        });
        $events->listen(DiscussionWasClosed::class, CreatePostWhenDiscussionIsClosed::class);
        $events->listen(DiscussionWasUnclosed::class, CreatePostWhenDiscussionIsUnclosed::class);
        $events->listen(Serializing::class, HideCommentsOfClosedDiscussion::class);

        $events->subscribe(DiscussionPolicy::class);
        $events->subscribe(PostPolicy::class);
    },
];
