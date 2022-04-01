@extends('layouts.admin')
{!! config(['app.title' => 'Manage Settings']) !!}

@push('meta')
    <x-meta title="Manage Settings" />
@endpush

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Settings
        </h5>

        <div class="card-block">
            {{ link_to(route('admin.setting.create'), '<i class="fa fa-plus"></i> New Setting', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}

            @if ($settings->isNotEmpty())
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                            <tr>
                                <th scope="row">
                                    {{ $setting->id }}
                                </th>
                                <td>
                                    {{ $setting->name }}
                                </td>
                                <td>
                                    <code>{{ $setting->value }}</code>
                                </td>
                                <td>
                                    {{ Str::limit($setting->description, 60) }}
                                </td>
                                <td>
                                    {{ $setting->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.setting.edit', ['id' => $setting->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this setting'
                                        ],
                                        null,
                                        false
                                    ) }}

                                    @if ($setting->is_deletable)
                                        {{ link_to(
                                            route('admin.setting.delete', ['id' => $setting->id]),
                                            '<i class="fa fa-remove"></i>',
                                            [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete this setting',
                                                'onclick' => "event.preventDefault();document.getElementById('delete-form').submit();"
                                            ],
                                            null,
                                            false
                                        ) }}
                                        {!! Form::open([
                                            'route' => ['admin.setting.delete', 'id' => $setting->id],
                                            'method' => 'delete',
                                            'id' => 'delete-form',
                                            'style' => 'display: none;'
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="col-md 12 text-xs-center">
                    {{ $settings->render() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There's no setting yet, create the first setting now !
                    </div>
                </div>
            @endif

        </div>
        <div class="card-footer">
            There're {{ $settings->count() }} settings.
        </div>
    </div>
</div>
@endsection
