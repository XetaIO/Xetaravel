<script type="text/javascript">
var _{{ array_get($biography, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . array_get($biography, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ route('users.user.show', ['slug' => ''], false) }}"
    };
    _{{ array_get($biography, 'id', 'myeditor') }} = editormd({
        id : "{{ array_get($biography, 'id', 'myeditor') }}",
        width : "{{ array_get($biography, 'width', config('editor.width')) }}",
        height : "{{ array_get($biography, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ array_get($biography, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ array_get($biography, 'emoji', config('editor.emoji')) }},
        taskList : {{ array_get($biography, 'taskList', config('editor.taskList')) }},
        tex : {{ array_get($biography, 'tex', config('editor.tex')) }},
        toc : {{ array_get($biography, 'toc', config('editor.toc')) }},
        tocm : {{ array_get($biography, 'tocm', config('editor.tocm')) }},
        codeFold : {{ array_get($biography, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ array_get($biography, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ array_get($biography, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ array_get($biography, 'path', config('editor.path')) }}",
        imageUpload : {{ array_get($biography, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! array_get($biography, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ array_get($biography, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(array_get($biography, 'pluginPath', config('editor.pluginPath'))) }}/",
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
