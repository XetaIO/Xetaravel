import Comment from './Comment';

declare let $: any;

export default class Blog
{
    constructor() {
        let comment: Comment = new Comment();

        this.deleteCommentModal();
    }

    /**
     * Handle the delete comment modal event.
     */
    protected deleteCommentModal()
    {
        /*$('#deleteCommentModal').on('show.bs.modal', function (event: any) {
            var button = $(event.relatedTarget);
            var route = button.data('form-action');

            var modal = $('#deleteCommentModal');
            modal.find('#deleteCommentForm').attr('action', route);
        });*/
    }
}