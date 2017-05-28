<script type="text/javascript">
var _{{ array_get($config, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . array_get($config, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ route('users.user.show', ['slug' => ''], false) }}"
    };
    _{{ array_get($config, 'id', 'myeditor') }} = editormd({
        id : "{{ array_get($config, 'id', 'myeditor') }}",
        width : "{{ array_get($config, 'width', config('editor.width')) }}",
        height : "{{ array_get($config, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ array_get($config, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ array_get($config, 'emoji', config('editor.emoji')) }},
        taskList : {{ array_get($config, 'taskList', config('editor.taskList')) }},
        tex : {{ array_get($config, 'tex', config('editor.tex')) }},
        toc : {{ array_get($config, 'toc', config('editor.toc')) }},
        tocm : {{ array_get($config, 'tocm', config('editor.tocm')) }},
        codeFold : {{ array_get($config, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ array_get($config, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ array_get($config, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ array_get($config, 'path', config('editor.path')) }}",
        imageUpload : {{ array_get($config, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! array_get($config, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ array_get($config, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(array_get($config, 'pluginPath', config('editor.pluginPath'))) }}/",
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
