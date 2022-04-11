@extends('layouts.app')
{!! config(['app.title' => 'Contact']) !!}

@push('meta')
  <x-meta title="Contact" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2  pb-2">
    <div class="col-md-12">
        <section class="contact">
            <div class="hr-divider">
                <h4 class="hr-divider-content hr-divider-heading font-xeta">
                    Contact
                </h4>
            </div>

            <p class="text-xs-center">
                You have found a problem on the site or you just want to contact me ? Use the form below and i will answer you shortly !
            </p>

            <div class="row">
                <div class="col-md-6">
                    {!! Form::open(['route' => 'page.contact', 'method' => 'post']) !!}

                        {!! Form::bsText(
                            'name',
                            'Name',
                            null,
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Your name...',
                                'required' => 'required',
                                'autofocus'
                            ]
                        ) !!}

                        {!! Form::bsEmail(
                            'email',
                            'E-mail',
                            null,
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Your E-mail...',
                                'required' => 'required'
                            ]
                        ) !!}

                        {!! Form::bsText(
                            'subject',
                            'Subject',
                            null,
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Subject...',
                                'required' => 'required'
                            ]
                        ) !!}

                        {!! Form::bsTextarea(
                            'message',
                            'Message',
                            null,
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Type your massage here...',
                                'required' => 'required'
                            ]
                        ) !!}

                         <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-danger' : '' }}">
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="form-control-feedback">
                                    {{ $errors->first('g-recaptcha-response') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::button('<i class="fa fa-envelope-o" aria-hidden="true"></i> Send', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>

                <div class="col-md-6">
                    <h4 class=" font-xeta">
                        Contact
                    </h4>
                    <ul class="contacts mb-2">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            Chalon sur Saône, 71100 France
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            Secret
                        </li>
                        <li>
                            <i class="fa fa-envelope-o"></i>
                            <a href="mailto:zoro.fmt@gmail.com">zoro.fmt@gmail.com</a>
                        </li>
                    </ul>

                    <h4 class=" font-xeta">
                        Social
                    </h4>
                    <ul class="social">
                        <li>
                            <a href="https://facebook.com/emeric.fevre.37" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/FMT_ZoRo" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </section>
    </div>
</div>

@endsection