<template>
    <div class="UsersNotifications">

        <!-- Mark all as read -->
        <button type="button" v-if="hasUnreadNotifs" v-on:click.prevent="markAllNotificationsAsRead" class="btn gap-2 mark-all-notifications-as-read mb-5">
            <i class="fa-solid fa-check"></i>
            Mark all notifications as read
        </button>

        <ul class="w-full">

            <li v-bind:key="notification" v-for="notification in notifications"
                v-on:mouseover.prevent="markNotificationAsRead(notification)"
                class="flex justify-between items-center relative bg-base-200 dark:bg-base-100 hover:bg-base-300 hover:dark:bg-base-200 rounded-lg p-5 mb-3"
                :class="'notification-' + notification.id + (notification.read_at === null ? ' rounded-tr-none' : '')">

                <div class="flex items-center">
                    <!-- Image -->
                    <img class="mr-3" v-if="notification.data.hasOwnProperty('image')" :src="'/' + notification.data.image" alt="Image" width="60">

                    <i v-else-if="notification.data.type == 'badge'" :class="notification.data.icon + ' text-5xl mr-3'" :style="'color:' + notification.data.color"></i>

                    <i v-else-if="notification.data.type == 'mention'" class="fa-solid fa-at text-5xl text-primary mr-3" style="vertical-align: middle;" aria-hidden="true"></i>

                    <img class="mr-3" v-else src="/images/logo.svg" alt="Image" width="60">

                    <!-- Message -->
                    <span v-html="notification.data.hasOwnProperty('message_key') ? formatMessage(notification) : notification.data.message" class="w-full"></span>
                </div>

                <!-- Badge new -->
                <span v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="absolute -right-2.5 -top-4 lg:top-1 text-sm text-white bg-[color:#f4645f] rounded rounded-tr-none color-white font-bold shadow-md px-1 before:bg-[color:#f4645f] before:content-[''] before:h-[5px] before:absolute before:right-0 before:top-[-4px] before:w-[10px] before:rounded-tr">
                    New
                </span>

                <!-- Delete -->
                <button v-on:click.prevent="deleteNotification(notification)" type="button" class="text-error tooltip" data-tip="Delete this notification">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </li>

        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            notifications: Array,
            routeDeleteNotification: String
        },

        data: function () {
            return {
                hasUnreadNotifs: false
            }
        },

        mounted() {
            this.hasUnreadNotifs = this.$parent.hasUnreadNotifs;

            this.$watch(() => { return this.$parent.hasUnreadNotifs },
                function (newVal, oldVal) {
                    if (this.hasUnreadNotifs != newVal) {
                        console.log('Parent UsersNotifications : triggrered');

                        this.hasUnreadNotifs = newVal;
                    }
                }
            );
        },

        watch: {
            hasUnreadNotifs: function () {
                if (this.hasUnreadNotifs != this.$parent.hasUnreadNotifs) {
                    this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                }
            }
        },

        methods: {

            /**
             * Delete a notification.
             *
             * @param {object} notification The notification to delete.
             *
             * @return {void}
             */
            deleteNotification: function (notification) {
                let _this = this;

                axios
                    .delete(this.routeDeleteNotification + '/' + notification.id)
                    .then(function(response) {
                        if (!response.error) {
                            _this.$parent.removeNotification(notification);
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while deleting the notification. ' + error);
                    });
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
                    });

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
                    });
            },

            /**
             * Update the notifications counter.
             *
             * @return {void}
             */
            updateNotificationsCounter: function () {
                let notifsCount = this.notifications.reduce(function (count, notif) {
                    return count + (notif.read_at === null ? 1 : 0);
                }, 0);
                this.$parent.$refs.toggle_notifications_number.setAttribute("data-number", '(' + notifsCount + ')');
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
            }
        }
    }
</script>
