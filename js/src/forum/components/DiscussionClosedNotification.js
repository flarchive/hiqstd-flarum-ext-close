import Notification from 'flarum/components/Notification';

export default class DiscussionClosedNotification extends Notification {
    icon() {
        return 'fas fa-eye-slash';
    }

    href() {
        const notification = this.props.notification;

        return app.route.discussion(notification.subject(), notification.content().postNumber);
    }

    content() {
        return app.translator.trans('flarum-ext-close.forum.notifications.discussion_closed_text', {user: this.props.notification.fromUser()});
    }
}
