import {extend} from 'flarum/extend';
import app from 'flarum/app';
import Model from 'flarum/Model';
import CommentPost from 'flarum/components/CommentPost';
import Discussion from 'flarum/models/Discussion';
import NotificationGrid from 'flarum/components/NotificationGrid';

import DiscussionClosedPost from './components/DiscussionClosedPost';
import DiscussionClosedNotification from './components/DiscussionClosedNotification';
import addCloseBadge from './addCloseBadge';
import addCloseControl from './addCloseControl';

app.initializers.add('flarum-ext-close', () => {
    app.postComponents.discussionClosed = DiscussionClosedPost;
    app.notificationComponents.discussionClosed = DiscussionClosedNotification;

    Discussion.prototype.isClosed = Model.attribute('isClosed');
    Discussion.prototype.canClose = Model.attribute('canClose');

    addCloseBadge();
    addCloseControl();

    extend(NotificationGrid.prototype, 'notificationTypes', function (items) {
        items.add('discussionClosed', {
            name: 'discussionClosed',
            icon: 'fas fa-eye-slash',
            label: app.translator.trans('flarum-ext-close.forum.settings.notify_discussion_closed_label')
        });
    });
});
