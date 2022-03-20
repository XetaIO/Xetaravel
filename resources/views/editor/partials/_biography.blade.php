<script type="text/javascript">
var _{{ Arr::get($biography, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . Arr::get($biography, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ URL::route('users.user.show', false) }}"
    };
    _{{ Arr::get($biography, 'id', 'myeditor') }} = editormd({
        id : "{{ Arr::get($biography, 'id', 'myeditor') }}",
        width : "{{ Arr::get($biography, 'width', config('editor.width')) }}",
        height : "{{ Arr::get($biography, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ Arr::get($biography, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ Arr::get($biography, 'emoji', config('editor.emoji')) }},
        taskList : {{ Arr::get($biography, 'taskList', config('editor.taskList')) }},
        tex : {{ Arr::get($biography, 'tex', config('editor.tex')) }},
        toc : {{ Arr::get($biography, 'toc', config('editor.toc')) }},
        tocm : {{ Arr::get($biography, 'tocm', config('editor.tocm')) }},
        codeFold : {{ Arr::get($biography, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ Arr::get($biography, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ Arr::get($biography, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ Arr::get($biography, 'path', config('editor.path')) }}",
        imageUpload : {{ Arr::get($biography, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! Arr::get($biography, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ Arr::get($biography, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(Arr::get($biography, 'pluginPath', config('editor.pluginPath'))) }}/",
        watch : false,
        editorTheme : 'mdn-like',
        placeholder : 'Type your biography here...',
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
