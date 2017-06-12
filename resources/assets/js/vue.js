import Vue from 'vue'
import Comments from './components/Comments.vue'
import Notifications from './components/Notifications.vue'
import UsersNotifications from './components/UsersNotifications.vue'

// Discuss
import DiscussUser from './components/Discuss/User.vue'
import DiscussShare from './components/Discuss/Share.vue'

Vue.config.productionTip = false;

const app = new Vue({
    el: '#app-vue',

    components: {
        Comments,
        Notifications,
        UsersNotifications,

        // Discuss
        DiscussUser,
        DiscussShare
    },

    data: {
        hasUnreadNotifs: Boolean,
        unreadNotificationsCount: Number,
        routeUserNotifications: String,
        routeMarkNotificationAsRead: String,
        routeMarkAllNotificationsAsRead: String
    },

    watch: {
        hasUnreadNotifs: function () {
            if (this.hasUnreadNotifs != this.$children.hasUnreadNotifs) {
                this.$children.hasUnreadNotifs = this.hasUnreadNotifs;
            }

            this.updateBell();
        }
    },

    methods: {

        /**
         * Get the notification URL related to the notification `type`.
         *
         * @param {object} notification The current notification that is handled.
         *
         * @return {string} The notification URL.
         */
        getNotificationUrl: function (notification) {
            if (notification.data.type == 'mention') {
                return notification.data.link;
            }

            return this.routeUserNotifications;
        },

        /**
         * Remove the `new` badge on the notification.
         *
         * @param {object} notification The notification where the `new` badge must be removed.
         *
         * @return {void}
         */
        removeNewBadge: function (notification) {
            let badges = document.getElementsByClassName('notification-' + notification.id + '-new');

            Array.from(badges).forEach((badge) => {
                badge.parentNode.removeChild(badge);
            });

            notification.read_at = new Date();
        },

        /**
         * Remove the `new` badge on the notification.
         *
         * @param {object} notification The notification where the `new` badge must be removed.
         *
         * @return {void}
         */
        removeNotification: function (notification) {
            let notifs = document.getElementsByClassName('notification-' + notification.id);

            Array.from(notifs).forEach((notif) => {
                notif.parentNode.removeChild(notif);
            });
        },

        /**
         * Handle the bell, depending if the user has new notification or not.
         *
         * @return {void}
         */
        updateBell: function () {
            if (this.hasUnreadNotifs) {
                this.$refs.toggle_notifications.setAttribute("data-number", '(' + this.unreadNotificationsCount + ')');
                this.$refs.toggle_icon_notifications.classList.add('animated', 'infinite', 'ringing');
                this.$refs.toggle_icon_notifications.classList.remove('text-body');
            } else {
                this.$refs.toggle_notifications.removeAttribute('data-number');
                this.$refs.toggle_icon_notifications.classList.remove('animated', 'infinite', 'ringing');
                this.$refs.toggle_icon_notifications.classList.add('text-body');
            }
        },

        /**
         * Format the message with vsprintf before rendering.
         *
         * @param {object} notification The current notification that is handled.
         *
         * @return {string} The parsed message.
         */
        formatMessage: function (notification) {
            return vsprintf(notification.data.message, notification.data.message_key);
        }
    }
});