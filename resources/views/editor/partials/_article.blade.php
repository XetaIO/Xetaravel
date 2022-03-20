<script type="text/javascript">
var _{{ Arr::get($articleConfig, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . Arr::get($articleConfig, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ URL::route('users.user.show', false) }}"
    };
    _{{ Arr::get($articleConfig, 'id', 'myeditor') }} = editormd({
        id : "{{ Arr::get($articleConfig, 'id', 'myeditor') }}",
        width : "{{ Arr::get($articleConfig, 'width', config('editor.width')) }}",
        height : "{{ Arr::get($articleConfig, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ Arr::get($articleConfig, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ Arr::get($articleConfig, 'emoji', config('editor.emoji')) }},
        taskList : {{ Arr::get($articleConfig, 'taskList', config('editor.taskList')) }},
        tex : {{ Arr::get($articleConfig, 'tex', config('editor.tex')) }},
        toc : {{ Arr::get($articleConfig, 'toc', config('editor.toc')) }},
        tocm : {{ Arr::get($articleConfig, 'tocm', config('editor.tocm')) }},
        codeFold : {{ Arr::get($articleConfig, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ Arr::get($articleConfig, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ Arr::get($articleConfig, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ Arr::get($articleConfig, 'path', config('editor.path')) }}",
        imageUpload : {{ Arr::get($articleConfig, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! Arr::get($articleConfig, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ Arr::get($articleConfig, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(Arr::get($articleConfig, 'pluginPath', config('editor.pluginPath'))) }}/",
        watch : false,
        theme : 'dark',
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
