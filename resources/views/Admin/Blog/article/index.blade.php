@extends('layouts.admin')
{!! config(['app.title' => 'Manage Articles']) !!}

@section('content')
<div class="col-sm-12 col-md-10 offset-md-2 p-2">
    {!! $breadcrumbs->render() !!}
</div>
<div class="col-sm-12 col-md-10 offset-md-2 pl-2 pr-2 pb-2">
    <div class="card card-inverse bg-inverse">
        <h5 class="card-header">
            Manage Articles
        </h5>
        <div class="card-block">
            {{ link_to(route('admin.blog.article.create'), '<i class="fa fa-plus"></i> New Article', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}
            <table class="table table-hover table-inverse">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Is display</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <th scope="row">
                                {{ $article->id }}
                            </th>
                            <td>
                                {{ link_to_route(
                                    'users.user.show',
                                    $article->user->username,
                                    ['id' => $article->user->id, 'slug' => $article->user->slug]
                                ) }}
                            </td>
                            <td>
                                {{ link_to_route(
                                    'blog.article.show',
                                    str_limit($article->title, 60),
                                    ['id' => $article->id, 'slug' => $article->slug]
                                ) }}
                            </td>
                            <td>
                                {{ link_to_route(
                                    'blog.category.show',
                                    $article->category->title,
                                    ['id' => $article->category->id, 'slug' => $article->category->slug]
                                ) }}
                            </td>
                            <td class="font-weight-bold {{ $article->is_display ? 'text-success' : 'text-danger' }}">
                                {{ $article->is_display ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                {{ $article->created_at->formatLocalized('%d %B %Y - %T') }}
                            </td>
                            <td>
                                {{ link_to(
                                    route('admin.blog.article.edit', ['slug' => $article->slug, 'id' => $article->id]),
                                    '<i class="fa fa-edit"></i>',
                                    [
                                        'class' => 'btn btn-sm btn-outline-info',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Edit this article',
                                        'escape' => false
                                    ],
                                    null,
                                    false
                                ) }}
                                {{ link_to(
                                    route('admin.blog.article.delete', ['id' => $article->id]),
                                    '<i class="fa fa-remove"></i>',
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete this article',
                                        'escape' => false
                                    ],
                                    null,
                                    false
                                ) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="col-md 12 text-xs-center">
                {{ $articles->render() }}
            </div>
        </div>
        <div class="card-footer text-muted">
            There're {{ $articles->count() }} articles. {{ $articles->where('is_display', false)->count() }} articles are not display.
        </div>
    </div>
</div>
@endsection
