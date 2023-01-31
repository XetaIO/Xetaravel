@extends('layouts.admin')
{!! config(['app.title' => 'Create an Item']) !!}

@push('meta')
    <x-meta title="Create an Item" />
@endpush

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Create an item
        </h5>
        <div class="card-block">
            {!! Form::open(['route' => 'admin.shop.item.create', 'files'=>'true', 'method' => 'post']) !!}

                {!! Form::bsText(
                    'title',
                    'Title',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-6',
                        'placeholder' => 'Item title...',
                        'required' => 'required',
                        'autofocus'
                    ]
                ) !!}

                {!! Form::bsSelect(
                    'shop_category_id',
                    $categories,
                    'Category',
                    1,
                    ['class' => 'form-control form-control-inverse col-md-2', 'required' => 'required']
                ) !!}

                {!! Form::bsCheckbox(
                    'is_display',
                    null,
                    1,
                    'Check to display this item',
                    [
                        'label' => 'Display',
                        'labelClass' => 'custom-control custom-checkbox form-control-inverse d-block'
                    ]
                ) !!}

                {!! Form::bsNumber(
                    'price',
                    'Price',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-1',
                        'placeholder' => 'Price...',
                        'required' => 'required'
                    ]
                ) !!}

                {!! Form::bsNumber(
                    'discount',
                    'Discount',
                    0,
                    [
                        'class' => 'form-control form-control-inverse col-md-1',
                        'placeholder' => 'Discount...',
                        'required' => 'required'
                    ]
                ) !!}

                {!! Form::bsNumber(
                    'quantity',
                    'Quantity (-1=Unlimited | 1+=Limited quantity)',
                    -1,
                    [
                        'class' => 'form-control form-control-inverse col-md-1',
                        'placeholder' => 'Quantity...',
                        'required' => 'required'
                    ]
                ) !!}

                {!! Form::bsText(
                    'start_at',
                    'Start At',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-2',
                        'placeholder' => 'Start At date...'
                    ]
                ) !!}

                {!! Form::bsText(
                    'end_at',
                    'End At',
                    null,
                    [
                        'class' => 'form-control form-control-inverse col-md-2',
                        'placeholder' => 'End At date...'
                    ]
                ) !!}

                <div class="form-group {{ $errors->has('item') ? 'has-danger' : '' }}">

                    <div class="fileinput fileinput-exists" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                            <img src="{{ asset('images/shop/default_icon.svg') }}" alt="Default Icon">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail">
                            <img src="{{ asset('images/shop/default_icon.svg') }}" alt="Item Icon">
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file">
                                <i class="fa fa-refresh"></i>
                                <span class="fileinput-exists">Change</span>
                                    {!! Form::file('item') !!}
                            </span>
                        </div>
                    </div>
                    @if ($errors->has('item'))
                        <div class="form-control-feedback">
                            {{ $errors->first('item') }}
                        </div>
                    @endif
                </div>

                {!! Form::bsTextarea(
                    'content',
                    'Content',
                    null,
                    ['class' => 'form-control form-control-inverse col-md-6', 'required' => 'required']
                ) !!}

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Create', ['type' => 'submit', 'class' => 'btn btn-outline-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
