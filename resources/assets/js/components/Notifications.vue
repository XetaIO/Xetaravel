<template>
    <div class="dropdown dropdown-end">
        <!-- Toggle notification menu -->
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" ref="toggle_icon_notifications" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span ref="toggle_notifications_number" class="badge badge-sm indicator-item badge-primary" v-bind:class="{ hidden: !hasUnreadNotifs }"></span>
            </div>
        </label>

        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-96 bg-base-100 shadow">
            <div class="card-body">
                <h3 class="card-title  justify-center">
                    Notifications
                </h3>

                <div class="divider my-0"></div>

                <ul>
                    <li :key="notification.id" v-for="notification in notifications" class="hover:bg-slate-200 cursor-pointer flex dark:hover:bg-slate-700 rounded mb-3">
                        <div class="indicator">
                        <a v-on:mouseover.prevent="markNotificationAsRead(notification)"
                            :href="getNotificationUrl(notification)" :class="'notification-' + notification.id" class="p-3 flex items-center">

                            <!-- Image -->
                            <img v-if="notification.data.hasOwnProperty('image')" :src="'/' + notification.data.image" alt="Image">

                            <i v-else-if="notification.data.type == 'badge'" :class="notification.data.icon" :style="'color:' + notification.data.color" class="text-3xl mr-2"></i>

                            <i v-else-if="notification.data.type == 'mention'" class="fa fa-at fa-3x text-primary"
                                aria-hidden="true"></i>

                            <img v-else src="/images/logo.svg" alt="Image">

                            <!-- Message -->
                            <span v-html="notification.data.hasOwnProperty('message_key') ? formatMessage(notification) : notification.data.message" class="message"></span>

                            <!-- Badge new -->
                            <span v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="badge badge-sm indicator-item badge-primary right-3">New</span>
                        </a>
                        </div>
                    </li>

                    <li>
                        <p v-if="!Array.isArray(notifications) || !notifications.length" class="m-2 text-center">
                            You don't have any notifications.
                        </p>
                    </li>
                </ul>

                <!-- Mark all as read -->
                <div v-if="hasUnreadNotifs" class="mb-1">
                    <button v-on:click.prevent="markAllNotificationsAsRead" class="btn btn-primary btn-block">
                            Mark all notifications as read
                    </button>
                </div>

                <div class="divider my-0"></div>

                <!-- Go to User Notification panel-->
                <div class="card-actions">
                    <a :href="routeUserNotifications" class="btn btn-ghost btn-block text-primary">
                        All Notifications
                    </a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            notifications: Array,
            unreadNotificationsCount: Number,
            hasUnreadNotifications: Boolean,
            routeUserNotifications: String,
            routeMarkNotificationAsRead: String,
            routeMarkAllNotificationsAsRead: String
        },

        data: function () {
            return {
                hasUnreadNotifs: false
            }
        },

        watch: {
            hasUnreadNotifs: function () {
                if (this.hasUnreadNotifs != this.$parent.hasUnreadNotifs) {
                    console.log('Child Notifications : triggrered');

                    this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                }
            }
        },

        mounted() {
            this.init();

            this.$watch(() => { return this.$parent.hasUnreadNotifs },
                function (newVal, oldVal) {
                    if (this.hasUnreadNotifs != newVal) {
                        this.hasUnreadNotifs = newVal;
                    }
                }
            );
        },

        methods: {

            init: function () {
                this.hasUnreadNotifs = this.hasUnreadNotifications;
                this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                this.$parent.unreadNotificationsCount = this.unreadNotificationsCount;
                this.$parent.routeUserNotifications = this.routeUserNotifications;
                this.$parent.routeMarkNotificationAsRead = this.routeMarkNotificationAsRead;
                this.$parent.routeMarkAllNotificationsAsRead = this.routeMarkAllNotificationsAsRead;
                this.$parent.$refs = this.$refs;
            },

            /**
             * Mark all notifications as read.
             *
             * @return {void}
             */
            markAllNotificationsAsRead: function () {
                let _this = this;

                axios
                    .post(this.$parent.routeMarkAllNotificationsAsRead)
                    .then(function(response) {
                        if (!response.error) {
                            _this.notifications.forEach(function(notification) {
                                if (notification.read_at === null) {
                                    _this.$parent.removeNewBadge(notification);
                                }
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while making all notifications as read. ' + error);
                    })

                this.hasUnreadNotifs = false;
                this.$parent.updateBell();
            },

            /**
             * Mark a notification as read.
             *
             * @param {object} notification The current notification to mark has read.
             *
             * @return {true|void} When the notification is already read.
             */
            markNotificationAsRead: function (notification) {
                let _this = this;

                // Prevent for sending unnecessary AJAX requests.
                if (notification.read_at !== null) {
                    return true;
                }

                axios
                    .post(this.$parent.routeMarkNotificationAsRead, {
                        id: notification.id
                    })
                    .then(function(response) {
                        if (!response.error) {
                            _this.$parent.removeNewBadge(notification);

                            let hasStillNewNotifs = _this.notifications.find(function (notif) {
                                return notif.read_at === null;
                            });

                            if (typeof hasStillNewNotifs == 'undefined') {
                                _this.$parent.updateBell();
                                _this.hasUnreadNotifs = false;
                            } else {
                                _this.updateNotificationsCounter();
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while making the notification as read. ' + error);
                    })
            },

            /**
             * Update the notifications counter.
             *
             * @return {void}
             */
            updateNotificationsCounter: function () {
                let notifsCount = this.notifications.reduce(function (count, notif) {
                    return count + (notif.read_at === null ? 1 : 0);
                }, 0)
                this.$parent.$refs.toggle_notifications_number.textContent = notifsCount;
            },

            /**
             * Format the message with vsprintf before rendering.
             *
             * @param {object} notification The current notification that is handled.
             *
             * @return {string} The parsed message.
             */
            formatMessage: function (notification) {
                return this.$parent.formatMessage(notification);
            },

            /**
             * Get the notification URL related to the notification `type`.
             *
             * @param {object} notification The current notification that is handled.
             *
             * @return {string} The notification URL.
             */
            getNotificationUrl: function (notification) {
                return this.$parent.getNotificationUrl(notification);
            }
        }
    }
</script>
