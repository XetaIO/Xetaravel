<template>
    <div class="dropdown dropdown-hover dropdown-top dropdown-middle ml-3">
        <button type="button" class="link link-hover flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4" viewBox="0 0 16 16">
                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
            </svg>
            Share
        </button>
        <div class="dropdown-content card card-compact shadow bg-base-100 rounded-box min-w-fit lg:min-w-[300px]" :class="{'text-slate-700 dark:text-white' : isSolved === true}">
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
            'routeInput',
            'isSolved'
        ]
    }
</script>