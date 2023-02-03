<template>
    <div class="dropdown dropdown-hover dropdown-top dropdown-middle ml-3">
        <button type="button" class="link link-hover flex gap-2 dark:text-current text-neutral">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                <path d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
            </svg>
            Share
        </button>
        <div class="dropdown-content card card-compact shadow bg-base-100 rounded-box min-w-fit lg:min-w-[300px]">
        <div class="card-body flex flex-col">
            <h3 class="card-title">
                {{ this.postType + ' #' + this.postId }}
            </h3>
            <input onFocus="this.select()" autofocus="autofocus" class="input input-bordered w-full" :value='routeInput' />
        </div>
        </div>
    </div>
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