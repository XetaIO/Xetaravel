<notifications
    :notifications="{{ $notifications->toJson() }}"
    :unread-notifications-count="{{ $unreadNotificationsCount }}"
    :has-unread-notifications="{{ var_export($hasUnreadNotifications) }}"
    :route-user-notifications="{{ var_export(route('users.notification.index')) }}"
    :route-mark-notification-as-read="{{ var_export(route('users.notification.markasread')) }}"
    :route-mark-all-notifications-as-read="{{ var_export(route('users.notification.markallasread')) }}">
</notifications>