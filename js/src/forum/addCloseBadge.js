import {extend} from 'flarum/extend';
import Discussion from 'flarum/models/Discussion';
import Badge from 'flarum/components/Badge';

export default function () {
    extend(Discussion.prototype, 'badges', function (badges) {
        if (this.isClosed()) {
            badges.add('closed', Badge.component({
                type: 'closed',
                label: app.translator.trans('flarum-ext-close.forum.badge.closed_tooltip'),
                icon: 'fas fa-eye-slash'
            }));
        }
    });
}
