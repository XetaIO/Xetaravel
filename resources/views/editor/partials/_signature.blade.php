<script type="text/javascript">
var _{{ Arr::get($signature, 'id', 'myeditor') }};
$(function() {
    editormd.emoji = {
        path : "{{ config('app.url') . Arr::get($signature, 'emojiPath', config('editor.emojiPath')) }}",
        ext : ".png"
    };
    editormd.urls = {
        atLinkBase : "{{ URL::route('users.user.show', false) }}"
    };
    _{{ Arr::get($signature, 'id', 'myeditor') }} = editormd({
        id : "{{ Arr::get($signature, 'id', 'myeditor') }}",
        width : "{{ Arr::get($signature, 'width', config('editor.width')) }}",
        height : "{{ Arr::get($signature, 'height', config('editor.height')) }}",
        saveHTMLToTextarea : {{ Arr::get($signature, 'saveHTMLToTextarea', config('editor.saveHTMLToTextarea')) }},
        emoji : {{ Arr::get($signature, 'emoji', config('editor.emoji')) }},
        taskList : {{ Arr::get($signature, 'taskList', config('editor.taskList')) }},
        tex : {{ Arr::get($signature, 'tex', config('editor.tex')) }},
        toc : {{ Arr::get($signature, 'toc', config('editor.toc')) }},
        tocm : {{ Arr::get($signature, 'tocm', config('editor.tocm')) }},
        codeFold : {{ Arr::get($signature, 'codeFold', config('editor.codeFold')) }},
        flowChart: {{ Arr::get($signature, 'flowChart', config('editor.flowChart')) }},
        sequenceDiagram: {{ Arr::get($signature, 'sequenceDiagram', config('editor.sequenceDiagram')) }},
        path : "{{ Arr::get($signature, 'path', config('editor.path')) }}",
        imageUpload : {{ Arr::get($signature, 'imageUpload', config('editor.imageUpload')) }},
        imageFormats : {!! Arr::get($signature, 'imageFormats', json_encode(config('editor.imageFormats'))) !!},
        imageUploadURL : "{{ Arr::get($signature, 'imageUploadURL', config('editor.imageUploadURL')) }}?_token={{ csrf_token() }}&from=xetaravel-editor-md",
        pluginPath : "{{ asset(Arr::get($signature, 'pluginPath', config('editor.pluginPath'))) }}/",
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
