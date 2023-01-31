import Vue from 'vue'
import moment from 'moment'
import Notifications from './components/Notifications.vue'
import UsersNotifications from './components/UsersNotifications.vue'

// Discuss
import DiscussUser from './components/Discuss/User.vue'
import DiscussShare from './components/Discuss/Share.vue'

Vue.config.productionTip = false;

Vue.filter('formatDate', function(date) {
    if (date) {
      return moment(String(date)).format('MM/DD/YYYY  hh:mm:ss')
    }
});

const app = new Vue({
    el: '#xetaravel-vue',

    components: {
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
        routeMarkAllNotificationsAsRead: String,
        nightMode: localStorage.getItem("nightMode") || false,
    },

    watch: {
        hasUnreadNotifs: function () {
            if (this.hasUnreadNotifs != this.$children.hasUnreadNotifs) {
                this.$children.hasUnreadNotifs = this.hasUnreadNotifs;
            }

            this.updateBell();
        },

        nightMode: function() {
			localStorage.setItem("nightMode", JSON.stringify(this.nightMode));

            if (String(this.nightMode) == 'true') {
                document.getElementsByTagName('html')[0].dataset.theme = "dark";
                document.getElementsByTagName('html')[0].setAttribute("class", "dark");
            } else {
                document.getElementsByTagName('html')[0].dataset.theme = "light";
                document.getElementsByTagName('html')[0].setAttribute("class", "light");
            }
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
                this.$refs.toggle_notifications_number.textContent = this.unreadNotificationsCount;
                this.$refs.toggle_icon_notifications.classList.add('animate-ringing');
            } else {
                this.$refs.toggle_notifications_number.textContent = "0";
                this.$refs.toggle_icon_notifications.classList.remove('animate-ringing');
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
    },

    mounted() {
        const darkMode = localStorage.getItem("nightMode");
        let theme = "light";

        if (darkMode == 'true') {
            theme = "dark";
            this.nightMode = true;
            document.getElementById("nightMode").checked = false;
        } else {
            this.nightMode = false;
            document.getElementById("nightMode").checked = true;
        }

        document.getElementsByTagName('html')[0].dataset.theme = theme;
        document.getElementsByTagName('html')[0].setAttribute("class", theme);
    }
});