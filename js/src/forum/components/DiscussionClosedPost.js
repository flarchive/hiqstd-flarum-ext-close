import EventPost from 'flarum/components/EventPost';

export default class DiscussionClosedPost extends EventPost {
    icon() {
        return this.props.post.content().closed
            ? 'fas fa-eye-slash'
            : 'fas fa-eye';
    }

    descriptionKey() {
        return this.props.post.content().closed
            ? 'flarum-ext-close.forum.post_stream.discussion_closed_text'
            : 'flarum-ext-close.forum.post_stream.discussion_unclosed_text';
    }
}
