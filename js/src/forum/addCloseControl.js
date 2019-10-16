import {extend} from 'flarum/extend';
import DiscussionControls from 'flarum/utils/DiscussionControls';
import DiscussionPage from 'flarum/components/DiscussionPage';
import Button from 'flarum/components/Button';

export default function () {
    extend(DiscussionControls, 'moderationControls', function (items, discussion) {
        if (discussion.canClose()) {
            items.add('close', Button.component({
                children: app.translator.trans(discussion.isClosed() ? 'flarum-ext-close.forum.discussion_controls.unclosed_button' : 'flarum-ext-close.forum.discussion_controls.close_button'),
                icon: 'fas fa-eye-slash',
                onclick: this.closeAction.bind(discussion)
            }));
        }
    });

    DiscussionControls.closeAction = function () {
        this.save({isClosed: !this.isClosed()}).then(() => {
            if (app.current instanceof DiscussionPage) {
                app.current.stream.update();
            }

            m.redraw();
        });
    };
}
