import { extend } from 'flarum/extend';
import app from 'flarum/app';
import PermissionGrid from 'flarum/components/PermissionGrid';

app.initializers.add('flarum-ext-close', () => {
  extend(PermissionGrid.prototype, 'moderateItems', items => {
    items.add('close', {
      icon: 'fas fa-eye-slash',
      label: app.translator.trans('flarum-ext-close.admin.permissions.close_discussions_label'),
      permission: 'discussion.close'
    }, 95);
  });
});
