declare let $: any;

export default class Discuss
{
    constructor() {
        this.deletePostModal();
    }

    /**
     * handle the delete post modal event.
     */
    protected deletePostModal()
    {
        $('#deletePostModal').on('show.bs.modal', function (event: any) {
            var button = $(event.relatedTarget);
            var route = button.data('form-action');

            var modal = $('#deletePostModal');
            modal.find('#deletePostForm').attr('action', route);
        });
    }
}