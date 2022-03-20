<script type="text/javascript">
var _{{ Arr::get($config, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . Arr::get($config, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ URL::route('users.user.show', false) }}"
    };
    _{{ Arr::get($config, 'id', 'myeditor') }} = editormd({
        id : "{{ Arr::get($config, 'id', 'myeditor') }}",
        width : "{{ Arr::get($config, 'width', config('editor.width')) }}",
        height : "{{ Arr::get($config, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ Arr::get($config, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ Arr::get($config, 'emoji', config('editor.emoji')) }},
        taskList : {{ Arr::get($config, 'taskList', config('editor.taskList')) }},
        tex : {{ Arr::get($config, 'tex', config('editor.tex')) }},
        toc : {{ Arr::get($config, 'toc', config('editor.toc')) }},
        tocm : {{ Arr::get($config, 'tocm', config('editor.tocm')) }},
        codeFold : {{ Arr::get($config, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ Arr::get($config, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ Arr::get($config, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ Arr::get($config, 'path', config('editor.path')) }}",
        imageUpload : {{ Arr::get($config, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! Arr::get($config, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ Arr::get($config, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(Arr::get($config, 'pluginPath', config('editor.pluginPath'))) }}/",
        watch : false,
        editorTheme : 'mdn-like',
        placeholder : 'Type your comment here...',
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
