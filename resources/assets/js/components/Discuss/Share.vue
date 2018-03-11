<template>
    <a href="javascript:void(0);" data-toggle="popover" data-html="true" data-placement="left" data-trigger="click" :data-template="getTemplate()" :data-content="getContent()">
        <i class="fa fa-share" aria-hidden="true"></i>
        Share
    </a>
</template>

<script>
    export default {
        props: [
            'postId',
            'postType',
            'routeInput'
        ],

        methods: {
            getContent: function () {
                return '<div class="discuss-conversation-meta-share">' +
                            '<span class="discuss-conversation-meta-share-number font-weight-bold">' +
                                this.postType + ' #' + this.postId +
                            '</span>' +
                            '<input onFocus="this.select()" autofocus="autofocus" class="discuss-conversation-meta-share-input form-control" value="' + this.routeInput + '">' +
                        '</div>';
            },
            getTemplate: function () {
                return '<div class="popover" role="tooltip" style="min-width: 380px;">' +
                            '<div class="popover-arrow"></div>' +
                            '<div class="popover-content"></div>' +
                        '</div>';
            }
    	}
    }
</script>