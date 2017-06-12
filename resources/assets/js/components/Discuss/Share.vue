<template>
    <a href="javascript:void(0);" data-toggle="tooltip" title="Share">
        <i class="fa fa-share" aria-hidden="true" data-toggle="popover" data-html="true" data-placement="left" data-trigger="click" :data-template="getTemplate()" :data-content="getContent()"></i>
    </a>
</template>

<script>
    export default {
        props: [
            'postId',
            'routeInput'
        ],

        methods: {
            getContent: function () {
                return '<div class="discuss-thread-meta-share">' +
                            '<span class="discuss-thread-meta-share-number font-weight-bold">' +
                                'Post #' + this.postId +
                            '</span>' +
                            '<input onFocus="this.select()" autofocus="autofocus" class="discuss-thread-meta-share-input form-control" value="' + this.routeInput + '">' +
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