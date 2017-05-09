@extends('layouts.app')
{!! config(['app.title' => 'Settings']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section class="mb-3">
                <h4 class="text-xs-center font-xeta">
                    Change your E-mail
                </h4>
                {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                    {!! Form::hidden('type', 'email') !!}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">E-mail</label>
                                <p class="form-control-static">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::bsEmail('email', 'New E-mail', null, [
                                'placeholder' => 'Your new E-mail...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group text-xs-center">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-floppy-o" aria-hidden="true"></i> Save', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </section>

            <section class="mb-3">
                <h4 class="text-xs-center font-xeta">
                    Change your Password
                </h4>
                {!! Form::open(['route' => 'users.user.settings', 'method' => 'put']) !!}
                    {!! Form::hidden('type', 'password') !!}
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::bsPassword('oldpassword', 'Current Password', [
                                'placeholder' => 'Your current Password...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::bsPassword('password', 'New Password', [
                                'placeholder' => 'Your new Password...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::bsPassword('password_confirmation', 'Confirm New Password', [
                                'placeholder' => 'Confirm your new Password...',
                                'required' => 'required'
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group text-xs-center">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Change', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </section>

            <section>
                <h4 class="text-xs-center font-xeta">
                    Delete your Account
                </h4>
                <div class="form-group text-xs-center">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteAccountModal">
                            <i class="fa fa-remove" aria-hidden="true"></i> Delete my Account
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">
                                    Delete my Account
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            {!! Form::open(['route' => 'users.user.delete', 'method' => 'delete']) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <p>
                                            Are you sure you want delete your account ? <strong>This operation is not reversible.</strong>
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
                                            'placeholder' => 'Your current Password...'
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
            </section>
        </div>
    </div>
</div>
@endsection
