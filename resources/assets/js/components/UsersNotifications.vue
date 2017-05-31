<template>
    <div class="UsersNotifications">

        <!-- Mark all as read -->
        <button v-if="hasUnreadNotifs" v-on:click.prevent="markAllNotificationsAsRead" class="btn btn-sm btn-outline-primary mark-all-notifications-as-read text-xs-center">
                <i class="fa fa-check" aria-hidden="true"></i> Mark all notifications as read
        </button>

        <table class="table table-hover table-notifications">

            <tr v-for="notification in notifications"
                v-on:mouseover.prevent="markNotificationAsRead(notification)"
                :class="'notification-' + notification.id + ' alert notification-item'">

                <td style="position: relative;">

                    <!-- Image -->
                    <img v-if="notification.data.hasOwnProperty('image')" :src="'/' + notification.data.image" alt="Image" width="60">

                    <i v-else-if="notification.data.type == 'mention'" class="fa fa-at fa-4x text-primary" style="vertical-align: middle;" aria-hidden="true"></i>

                    <img v-else src="/images/logo.svg" alt="Image" width="60">

                    <!-- Message -->
                    <span v-html="notification.data.hasOwnProperty('message_key') ? formatMessage(notification) : notification.data.message" class="message"></span>

                    <!-- Badge new -->
                    <strong v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="new">
                        <span></span>
                        New
                    </strong>

                    <!-- Delete -->
                    <button v-on:click.prevent="deleteNotification(notification)" type="button" class="close text-danger" data-toggle="tooltip" title="Delete this notification" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </td>
            </tr>

        </table>
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
                this.$parent.$refs.toggle_notifications.setAttribute("data-number", '(' + notifsCount + ')');
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
