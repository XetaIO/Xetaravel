@extends('layouts.admin')
{!! config(['app.title' => 'Update ' . e($setting->name)]) !!}

@push('meta')
    <x-meta title="Update : {{ e($setting->name) }}" />
@endpush

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Update : {{ $setting->name }}
        </h5>

        <div class="card-block">

            <p class="text-danger">
                Be careful when editing the setting's name, it will probably broke the code !
            </p>

            {!! Form::model(
                $setting,
                [
                    'route' => ['admin.setting.update', $setting->id],
                    'method' => 'put'
                ]
            ) !!}

                {!! Form::bsText(
                    'name',
                    'Name',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'test.setting',
                        'required' => 'required',
                    ]
                ) !!}

                {!! Form::bsText(
                    'value',
                    'Value ',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'Type your value here...',
                        'required' => 'required',
                    ]
                ) !!}

                {!! Form::bsRadio(
                    'type',
                    'value_int',
                    1,
                    'Value Int',
                    [
                        'label' => 'Value Type',
                        'labelClass' => 'custom-control custom-radio form-control-inverse d-block'
                    ],
                    'form-control-label form-control-label-inverse'
                ) !!}

                {!! Form::bsRadio(
                    'type',
                    'value_str',
                    false,
                    'Value Str',
                    ['labelClass' => 'custom-control custom-radio form-control-inverse d-block']
                ) !!}

                {!! Form::bsRadio(
                    'type',
                    'value_bool',
                    false,
                    'Value Bool',
                    ['labelClass' => 'custom-control custom-radio form-control-inverse d-block']
                ) !!}

                {!! Form::bsTextarea(
                    'description',
                    'Description',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'placeholder' => 'Setting description...']
                ) !!}

                {!! Form::bsCheckbox(
                    'is_deletable',
                    null,
                    null,
                    'Check for yes',
                    [
                        'label' => 'Is deletable ?',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ]
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-edit" aria-hidden="true"></i> Update', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
