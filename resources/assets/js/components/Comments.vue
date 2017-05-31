<template>
    <div class="comments">
        <figure class="media" :id="'comment-' + comment.id" v-for="comment in comments">
            <div class="media-left">
                <a :href="comment.user.profile_url">
                    <img class="media-object rounded-circle" :src="comment.user.avatar_small" alt="Avatar" height="64px" width="64px">
                </a>
            </div>

            <div class="media-body">
                <h5 class="media-heading">
                    <a :href="comment.user.profile_url">
                        {{ comment.user.username }}
                    </a>
                </h5>

                <time :datetime="getDate(comment.created_at)" :title="getDate(comment.created_at)" data-toggle="tooltip">
                    <small class="text-muted">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        {{ comment.created_at }}
                    </small>
                </time>

                <figcaption v-html="comment.content_markdown"></figcaption>
            </div>
        </figure>
    </div>
</template>

<script>
    export default {
        props: ['comments'],

        methods: {
    		getDate: function (now) {
                let date = new Date(now);
                date.setHours(date.getHours() + 2);

                return date.toISOString();
    		}
    	}
    }
</script>
