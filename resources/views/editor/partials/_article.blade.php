<script type="text/javascript">
var _{{ array_get($articleConfig, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . array_get($articleConfig, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ route('users.user.show', ['slug' => ''], false) }}"
    };
    _{{ array_get($articleConfig, 'id', 'myeditor') }} = editormd({
        id : "{{ array_get($articleConfig, 'id', 'myeditor') }}",
        width : "{{ array_get($articleConfig, 'width', config('editor.width')) }}",
        height : "{{ array_get($articleConfig, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ array_get($articleConfig, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ array_get($articleConfig, 'emoji', config('editor.emoji')) }},
        taskList : {{ array_get($articleConfig, 'taskList', config('editor.taskList')) }},
        tex : {{ array_get($articleConfig, 'tex', config('editor.tex')) }},
        toc : {{ array_get($articleConfig, 'toc', config('editor.toc')) }},
        tocm : {{ array_get($articleConfig, 'tocm', config('editor.tocm')) }},
        codeFold : {{ array_get($articleConfig, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ array_get($articleConfig, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ array_get($articleConfig, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ array_get($articleConfig, 'path', config('editor.path')) }}",
        imageUpload : {{ array_get($articleConfig, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! array_get($articleConfig, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ array_get($articleConfig, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(array_get($articleConfig, 'pluginPath', config('editor.pluginPath'))) }}/",
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
