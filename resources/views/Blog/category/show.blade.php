@extends('layouts.app')
{!! config(['app.title' => 'Category : ' . $category->title]) !!}

@section('content')
<div class="container pb-1 pt-4">
    <div class="blog-header mt-2">
        <div class="container">
            <h1 class="blog-title">
                {{ $category->title }}
            </h1>
            <p class="lead blog-description text-muted">
                {{ $category->description }}
            </p>
        </div>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2">
    <div class="row">
        <div class="col-md-9">
            @include('partials.blog._articles')
        </div>

        <div class="col-md-3">
            @include('partials.blog._sidebar')
        </div>

    </div>
</div>
@endsection
