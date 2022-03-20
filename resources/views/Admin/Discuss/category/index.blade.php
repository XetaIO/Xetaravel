@extends('layouts.admin')
{!! config(['app.title' => 'Manage Categories']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Categories
        </h5>
        <div class="card-block">
            {{ link_to(route('admin.discuss.category.create'), '<i class="fa fa-plus"></i> New Category', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}
            @if ($categories->isNotEmpty())
                <table class="table table-hover table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Conversations</th>
                            <th>Is locked</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                            <th scope="row">
                                    {{ $category->id }}
                                </th>
                                <td class="font-weight-bold">
                                    {{ link_to(
                                        $category->category_url,
                                        Str::limit($category->title, 60),
                                        [
                                            'style' => "color: {$category->color};"
                                        ]
                                    ) }}
                                </td>
                                <td>
                                    {{ Str::limit($category->description, 60) }}
                                </td>
                                <td>
                                    {{ $category->conversation_count }}
                                </td>
                                <td class="font-weight-bold {{ $category->is_locked ? 'text-danger' : 'text-success' }}">
                                    {{ $category->is_locked ? 'Yes' : 'No' }}
                                </td>
                                <td>
                                    {{ $category->created_at->formatLocalized('%d %B %Y - %T') }}
                                </td>
                                <td>
                                    {{ link_to(
                                        route('admin.discuss.category.edit', ['slug' => $category->slug, 'id' => $category->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this category',
                                            'escape' => false
                                        ],
                                        null,
                                        false
                                    ) }}
                                    {{ link_to(
                                        route('admin.discuss.category.delete', ['id' => $category->id]),
                                        '<i class="fa fa-remove"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete this category',
                                            'onclick' => "event.preventDefault();document.getElementById('delete-form-{$category->id}').submit();",
                                            'escape' => false
                                        ],
                                        null,
                                        false
                                    ) }}
                                    {!! Form::open([
                                        'route' => ['admin.discuss.category.delete', 'id' => $category->id],
                                        'method' => 'delete',
                                        'id' => "delete-form-{$category->id}",
                                        'style' => 'display: none;'
                                    ]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="col-md 12 text-xs-center">
                    {{ $categories->render() }}
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                        There's no category yet, create your first category now !
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer text-muted">
            There're {{ $categories->count() }} categories.
        </div>
    </div>
</div>
@endsection
