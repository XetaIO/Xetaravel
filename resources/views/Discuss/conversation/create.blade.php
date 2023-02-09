@extends('layouts.app')
{!! config(['app.title' => 'Start a discussion']) !!}

@push('meta')
  <x-meta title="Start a discussion" />
@endpush

@push('style')
    {!! editor_css() !!}
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $comment = [
            'id' => 'conversationEditor',
            'height' => '350'
        ];
    @endphp

    @include('editor/partials/_comment', $comment)


    <script src="{{ asset('js/libs/highlight.min.js') }}"></script>
    <script type="text/javascript">
        // HighlightJS
        hljs.highlightAll();

        // DarkMode for highlight
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                el.classList.add('dark:bg-base-300', 'dark:text-slate-300');
            });
        });
    </script>
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 ">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-3 col-span-12 px-3">
            @include('Discuss::partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 px-3">
            <div class="flexflex-col border border-gray-200 p-3 px-5 rounded-lg dark:bg-base-300 dark:border-gray-700">
                <h3 class="text-2xl text-center">
                    Start a discussion
                </h3>

                <x-form.form method="post" action="{{ route('discuss.conversation.create') }}">
                    {!! Form::bsText(
                        'title',
                        'Title',
                        null,
                        [
                            'placeholder' => 'Discussion title...',
                            'required' => 'required',
                            'autofocus'
                        ]
                    ) !!}

                    {!! Form::bsSelect(
                        'category_id',
                        $categories,
                        'Category',
                        1,
                        [
                            'required' => 'required'
                        ]
                    ) !!}

                    {!! Form::bsTextarea(
                        'content',
                        'Content',
                        old('content'),
                        [
                            'required' => 'required',
                            'editor' => 'conversationEditor',
                            'style' => 'display:none;'
                        ]
                    ) !!}

                    @permission ('manage.discuss.conversations')

                        <h3 class="text-xl">
                            Moderation
                        </h3>

                        {!! Form::bsCheckbox(
                            'is_locked',
                            null,
                            0,
                            'Check to lock this discussion'
                        ) !!}


                        {!! Form::bsCheckbox(
                            'is_pinned',
                            null,
                            0,
                            'Check to pin this discussion'
                        ) !!}
                    @endpermission

                    <div class="form-group text-xs-center">
                        {!! Form::button(
                            '<i class="fa fa-pencil" aria-hidden="true"></i> Start the Discussion',
                            ['type' => 'submit', 'class' => 'btn btn-primary gap-2']
                        ) !!}
                    </div>
                </x-form.form>
            </div>
        </div>
    </div>
</section>
@endsection