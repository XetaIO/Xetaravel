@extends('layouts.admin')
{!! config(['app.title' => 'Edit ' . e($user->username)]) !!}

@push('style')
    {!! editor_css() !!}
    <link href="{{ mix('css/editor-md.custom.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {!! editor_js() !!}
    <script src="{{ asset(config('editor.pluginPath') . '/emoji-dialog/emoji-dialog.js') }}"></script>

    @php
        $signature = [
            'id' => 'signatureEditor',
            'height' => '200',
        ];
    @endphp
    @include('editor/partials/_signature', $signature)

    @php
        $biography = [
            'id' => 'biographyEditor',
            'height' => '250'
        ];
    @endphp
    @include('editor/partials/_biography', [$biography, $signature])

@endpush

@section('content')
{{-- Header --}}
<div class="col-sm-12 col-md-10 offset-md-2 pl-0 pr-0">
    <div class="profile-container">
        <div class="profile-header">
            <div class="background-container">
                {!! Html::image($user->profile_background, 'Profile background', ['class' => 'background']) !!}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-information text-xs-center">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle']) !!}
                                <h2 class="username font-xeta">
                                    {{ $user->username }}
                                </h2>
                                <h4 class="full-name">
                                    {{ $user->full_name }}
                                </h4>
                            </li>
                            <li class="col-md-6 offset-md-3 mt-3 mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-inline-block mr-2">
                                            <h5 class="base-header">
                                                Comments
                                            </h5>
                                            <h6 class="base-header major">
                                                {{ $user->comment_count }}
                                            </h6>
                                        </div>
                                        <div class="d-inline-block mr-2">
                                            <h5 class="base-header">
                                                Articles
                                            </h5>
                                            <h6 class="base-header major">
                                                {{ $user->article_count }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($user->facebook)
                                            <div class="d-inline-block mr-2">
                                                {!! Html::link(
                                                    url('http://facebook.com/' . e($user->facebook)),
                                                    '<i class="fa fa-facebook fa-2x"></i>',
                                                    [
                                                        'class' => 'text-primary',
                                                        'target' => '_blank',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'top',
                                                        'title' => 'http://facebook.com/' . e($user->facebook)
                                                    ],
                                                    null,
                                                    false
                                                ) !!}
                                            </div>
                                        @endif
                                        @if ($user->twitter)
                                            <div class="d-inline-block mr-2">
                                                {!! Html::link(
                                                    url('http://twitter.com/' . e($user->twitter)),
                                                    '<i class="fa fa-twitter fa-2x"></i>',
                                                    [
                                                        'class' => 'text-primary',
                                                        'target' => '_blank',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'top',
                                                        'title' => 'http://twitter.com/' . e($user->twitter)
                                                    ],
                                                    null,
                                                    false
                                                ) !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Breadcrumbs --}}
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>

{{-- User Informations --}}
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header text-xs-center">
            Edit {{ $user->username }}
        </h5>

        <div class="card-block">
            <div class="row">
                <div class="col-md-3 text-xs-center">
                    <h5>
                        Avatar
                    </h5>

                    {!! Html::image($user->avatar_small, e($user->username), ['class' => 'rounded-circle img-thumbnail mb-1']) !!}
                    <br />

                    {{ link_to(
                        route('admin.user.user.deleteavatar', $user->id),
                        '<i class="fa fa-remove"></i> Delete avatar',
                        [
                            'class' => 'btn btn-outline-primary mb-1',
                            'onclick' => 'event.preventDefault();document.getElementById(\'delete-avatar-form\').submit();'],
                        null,
                        false
                    ) }}

                    {!! Form::open([
                        'route' => ['admin.user.user.deleteavatar', $user->id],
                        'id' => 'delete-avatar-form',
                        'method' => 'delete',
                        'style' => 'display: none;'
                    ]) !!}
                    {!! Form::close() !!}

                    <p class="mb-1">
                        Member since {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                    </p>

                    <button type="button" class="btn btn-outline-danger mb-1" data-toggle="modal" data-target="#deleteAccountModal">
                        <i class="fa fa-remove" aria-hidden="true"></i> Delete account
                    </button>

                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModal" aria-hidden="true">
                        <div class="modal-dialog text-body-primary" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAccountModalLabel">
                                        Delete <strong>{{ $user->username }}</strong> Account
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                {!! Form::open([
                                    'route' => ['admin.user.user.delete', $user->id],
                                    'method' => 'delete'
                                ]) !!}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>
                                                Are you sure you want delete this account ? <strong>This operation is not reversible.</strong>
                                            </p>
                                        </div>
                                        {!! Form::bsInputGroup(
                                            'password',
                                            null,
                                            null,
                                            [
                                                'span' => '<i class="fa fa-lock"></i>',
                                                'required' => 'required',
                                                'type' => 'password',
                                                'placeholder' => 'Your password...'
                                            ]
                                        ) !!}
                                    </div>

                                    <div class="modal-actions">
                                        {!! Form::button('Yes, I confirm !', ['type' => 'submit', 'class' => 'ma ma-btn ma-btn-danger']) !!}
                                        <button type="button" class="ma ma-btn ma-btn-success" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::model($user, ['route' => ['admin.user.user.update', $user->id], 'method' => 'put']) !!}

                        {!! Form::bsText(
                            'username',
                            'Username',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'email',
                            'E-mail',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsSelect(
                            'roles[]',
                            $roles,
                            'Roles',
                            $user->roles->pluck('id')->toArray(),
                            ['class' => 'form-control form-control-inverse col-md-4', 'multiple'],
                            $optionsAttributes
                        ) !!}

                        {!! Form::bsText(
                            'account[first_name]',
                            'First Name',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsText(
                            'account[last_name]',
                            'Last Name',
                            null,
                            ['class' => 'form-control form-control-inverse']
                        ) !!}

                        {!! Form::bsInputGroup(
                            'account[facebook]',
                            'Facebook',
                            null,
                            [
                                'span' => 'http://facebook.com/',
                                'spanStyle' => 'min-width:180px;',
                                'spanClass' => 'input-group-addon input-group-addon-inverse',
                                'class' => 'form-control form-control-inverse'
                            ]
                        ) !!}

                        {!! Form::bsInputGroup(
                            'account[twitter]',
                            'Twitter',
                            null,
                            [
                                'span' => 'http://twitter.com/',
                                'spanStyle' => 'min-width:180px;',
                                'spanClass' => 'input-group-addon input-group-addon-inverse',
                                'class' => 'form-control form-control-inverse'
                            ]
                        ) !!}

                        {!! Form::bsTextarea(
                            'account[biography]',
                            'Biography',
                            null,
                            ['editor' => 'biographyEditor', 'style' => 'display:none;']
                        ) !!}

                        {!! Form::bsTextarea(
                            'account[signature]',
                            'Signature',
                            null,
                            ['editor' => 'signatureEditor', 'style' => 'display:none;']
                        ) !!}

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Update', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>

                <div class="col-md-3">
                    <h4>
                        Others Informations
                    </h4>
                    <div class="form-group">
                        <label class="form-control-label">
                            Last Login IP
                        </label>
                        <p class="form-control-static text-muted">
                            {{ $user->last_login_ip }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">
                            Registered IP
                        </label>
                        <p class="form-control-static text-muted">
                            {{ $user->register_ip }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label ">
                            Registered
                        </label>
                        <p class="form-control-static text-muted">
                            {{ $user->created_at->formatLocalized('%d %B %Y - %T') }}
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">
                            Last Updated
                        </label>
                        <p class="form-control-static text-muted">
                            {{ $user->updated_at->formatLocalized('%d %B %Y - %T') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
