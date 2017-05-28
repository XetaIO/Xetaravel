<script type="text/javascript">
var _{{ array_get($signature, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . array_get($signature, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ route('users.user.show', ['slug' => ''], false) }}"
    };
    _{{ array_get($signature, 'id', 'myeditor') }} = editormd({
        id : "{{ array_get($signature, 'id', 'myeditor') }}",
        width : "{{ array_get($signature, 'width', config('editor.width')) }}",
        height : "{{ array_get($signature, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ array_get($signature, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ array_get($signature, 'emoji', config('editor.emoji')) }},
        taskList : {{ array_get($signature, 'taskList', config('editor.taskList')) }},
        tex : {{ array_get($signature, 'tex', config('editor.tex')) }},
        toc : {{ array_get($signature, 'toc', config('editor.toc')) }},
        tocm : {{ array_get($signature, 'tocm', config('editor.tocm')) }},
        codeFold : {{ array_get($signature, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ array_get($signature, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ array_get($signature, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ array_get($signature, 'path', config('editor.path')) }}",
        imageUpload : {{ array_get($signature, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! array_get($signature, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ array_get($signature, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(array_get($signature, 'pluginPath', config('editor.pluginPath'))) }}/",
        watch : false,
        editorTheme : 'mdn-like',
        placeholder : 'Type your signature here...',
        toolbarIcons : function () {
            return [
                "undo", "redo", "|",
                "bold", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                "h3", "h4", "h5", "h6", "|",
                "hr", "|",
                "link", "code", "datetime", "emojiCustom", "html-entities", "|",
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
