declare let axios: any;
declare let editormd: any;
declare let $: any;

export default class Post
{
    /**
     * The button element.
     *
     * @property {HTMLCollectionOf} button
     */
    private buttons: HTMLCollectionOf<Element>;

    /**
     * The constructor.
     */
    constructor() {
        this.initEditButton();
    }

    /**
     * Handle Edit button for posts.
     */
    protected initEditButton()
    {
        this.buttons = document.getElementsByClassName('postEditButton');

        let __this = this;

        Array.from(this.buttons).forEach(function (button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                let id = button.getAttribute("data-id");
                let route = button.getAttribute("data-route");

                axios.get(route)
                    .then(function (response: any) {
                        let post = document.getElementById('disccuss-post-edit-' + id);

                        if (response.data.error == true || post !== null) {
                            return;
                        }

                        let content = $('#post-' + id + ' .discuss-conversation-content');
                        let edit = $('#post-' + id + ' .discuss-conversation-edit');

                        content.addClass('d-none');
                        edit.append(response.data.form);

                        var testEditormd = editormd("editPostEditor-" + id, {
                            width: "100%",
                            height: 340,
                            markdown: response.data.markdown
                        });
                    })
                    .catch(function (error: any) {
                        console.log(error);
                    });

            }, false);
        });
    }

}