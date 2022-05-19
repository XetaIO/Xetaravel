import Post from './Post';

declare let $: any;

export default class Discuss
{
    constructor() {
        let post: Post = new Post();

        this.deletePostModal();
    }

    /**
     * Handle the delete post modal event.
     */
    protected deletePostModal()
    {
        /*const modal = document.getElementById('deletePostModal');
        console.log(modal);
        modal.addEventListener('show.bs.modal', function(event) {
            console.log(event);

        });*/
        /*$('#deletePostModal').on('show.bs.modal', function (event: any) {
            console.log(event);
            var button = $(event.relatedTarget);
            var route = button.data('form-action');

            var modal = $('#deletePostModal');
            modal.find('#deletePostForm').attr('action', route);
        });*/
    }
}