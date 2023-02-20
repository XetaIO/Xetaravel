@php
$form = '<div id="discuss-post-edit-' . $post->getKey() . '">
            <form method="POST" action="' . route('discuss.post.edit', ['id' => $post->getKey()]) . '" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="PUT">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <div class="form-group">
                    <div id="editPostEditor-' . $post->getKey() . '">
                        <textarea class="form-control" rows="5" placeholder="Your message here..." required="required" editor="editPostEditor-' . $post->getKey() . '" style="display:none;" name="content" cols="50"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-pencil"></i>
                    Edit
                </button>
                <button type="button" data-id="' . $post->getKey() . '" class="btn gap-2 cancelEditButton">
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </button>
            </form>
            <script type="text/javascript">
                (function () {
                    const cancelEditButton = document.querySelectorAll(\'.cancelEditButton\');
                    cancelEditButton.forEach(function (button) {
                        button.addEventListener(\'click\', function (event) {
                            event.preventDefault();

                            let id = event.target.dataset.id;
                            let content = document.getElementById(\'post-\' + id).getElementsByClassName(\'discuss-conversation-content\')[0];
                            content.classList.remove(\'hidden\');

                            let edit = document.getElementById(\'discuss-post-edit-\' + id);
                            edit.remove();
                        });
                    });
                })();
            </script>
        </div>';
@endphp

{!! json_encode(['error' => false, 'form' => $form, 'markdown' => $post->content]) !!}