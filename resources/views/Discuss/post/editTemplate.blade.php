@php
$form = '<div id="disccuss-post-edit-' . $post->getKey() . '">
            <form method="POST" action="' . route('discuss.post.edit', ['id' => $post->getKey()]) . '" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="PUT">
                <input name="_token" type="hidden" value="' . csrf_token() . '">
                <div class="form-group">
                    <div id="editPostEditor-' . $post->getKey() . '">
                        <textarea class="form-control" rows="5" placeholder="Your message here..." required="required" editor="editPostEditor-' . $post->getKey() . '" style="display:none;" name="content" cols="50"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    Edit
                </button>
                <button type="button" data-id="' . $post->getKey() . '" class="btn btn-outline-secondary cancelEditButton">
                    <i class="fa fa-remove" aria-hidden="true"></i>
                    Cancel
                </button>
            </form>
            <script type="text/javascript">
            $(function() {
                $(".cancelEditButton").click(function (event) {
                    event.preventDefault();

                    var id = $(this).attr("data-id");

                    $("#post-" + id + " .discuss-conversation-content").removeClass("d-none");
                    $("#disccuss-post-edit-" + id).remove();
                });
            });
            </script>
        </div>';
@endphp

{!! json_encode(['error' => false, 'form' => $form, 'markdown' => $post->content]) !!}