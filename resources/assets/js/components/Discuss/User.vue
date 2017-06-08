<template>
    <a href="javascript:void(0);" class="font-weight-bold" data-toggle="popover" :data-template="getTemplate()" data-html="true" :data-content="getContent()" data-placement="top" data-trigger="click">
        {{ user.username }}
    </a>
</template>

<script>
    export default {
        props: [
            'user',
            'createdAt',
            'lastLogin'
        ],

        methods: {
            getContent: function () {
                return '<div class="discuss-popover-user-avatar float-xs-left">' +
                            '<img class="img-thumbnail" src="' + this.user.avatar_small + '" width="50px" />' +
                        '</div>' +
                        '<div class="discuss-popover-user-profile">' +
                            '<div class="discuss-popover-user-username">' +
                                '<h5 class="font-weight-bold">' +
                                    '<a href="' + this.user.profile_url + '">' +
                                        this.user.full_name +
                                    '</a>' +
                                '</h5>' +
                            '</div>' +
                            '<div class="discuss-popover-user-info">' +
                                '<ul class="list-inline">' +
                                    '<li class="list-inline-item mr-1" data-toggle="tooltip" title="Last seen">' +
                                        '<i class="fa fa-clock-o"></i> ' + this.lastLogin +
                                    '</li>' +
                                    '<li class="list-inline-item mr-1" data-toggle="tooltip" title="Registered">' +
                                        '<i class="fa fa-calendar"></i> ' + this.createdAt +
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</div>';
            },
            getTemplate: function () {
                return '<div class="popover discuss-popover-user" role="tooltip">' +
                            '<div class="background-container">' +
                                '<img src="' + this.user.profile_background + '" alt="Profile background" class="background">' +
                            '</div>' +
                            '<div class="popover-arrow"></div>' +
                            '<div class="popover-content"></div>' +
                        '</div>';
            },
    		getDate: function (now) {
                let date = new Date(now);
                date.setHours(date.getHours() + 2);

                return date.toISOString();
    		}
    	}
    }
</script>