<script type="text/javascript">
var _{{ Arr::get($comment, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . Arr::get($comment, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ URL::route('users.user.show', false) }}"
    };
    _{{ Arr::get($comment, 'id', 'myeditor') }} = editormd({
        id : "{{ Arr::get($comment, 'id', 'myeditor') }}",
        width : "{{ Arr::get($comment, 'width', config('editor.width')) }}",
        height : "{{ Arr::get($comment, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ Arr::get($comment, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ Arr::get($comment, 'emoji', config('editor.emoji')) }},
        taskList : {{ Arr::get($comment, 'taskList', config('editor.taskList')) }},
        tex : {{ Arr::get($comment, 'tex', config('editor.tex')) }},
        toc : {{ Arr::get($comment, 'toc', config('editor.toc')) }},
        tocm : {{ Arr::get($comment, 'tocm', config('editor.tocm')) }},
        codeFold : {{ Arr::get($comment, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ Arr::get($comment, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ Arr::get($comment, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ Arr::get($comment, 'path', config('editor.path')) }}",
        imageUpload : {{ Arr::get($comment, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! Arr::get($comment, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ Arr::get($comment, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(Arr::get($comment, 'pluginPath', config('editor.pluginPath'))) }}/",
        watch : false,
        editorTheme : 'mdn-like',
        placeholder : 'Type your comment here...',
        autoFocus : {{ Arr::get($comment, 'autoFocus', config('editor.autoFocus')) }},
        toolbarIcons : function () {
            return [
                "undo", "redo", "|",
                "bold", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                "h1", "h2", "h3", "h4", "h5", "h6", "|",
                "list-ul", "list-ol", "hr", "|",
                "link", "reference-link", "image", "code", "code-block", "table", "datetime", "emojiCustom", "html-entities", "|",
                "goto-line", "watch", "preview", "fullscreen", "clear", "search", "||",
                "help"
            ];
        },
        toolbarIconsClass : {
           emojiCustom : "fa-smile-o"
        },
        toolbarHandlers : {
            emojiCustom : function() {
                this.emojiDialog();
            }
        },
        lang : {
           toolbar : {
               emojiCustom : 'Emoji'
           }
       }
    });
});
</script>
