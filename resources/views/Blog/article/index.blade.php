@extends('layouts.app')
{!! config(['app.title' => 'Blog']) !!}

@push('meta')
    <x-meta title="Blog" />
@endpush

@section('content')
<div class="container pb-1 pt-4">
    <div class="blog-header mt-2">
        <div class="container">
            <div class="blog-post-title">
                Blog
            </div>
        </div>
    </div>
</div>
<hr />
<div class="container pt-0 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<hr />
<div class="container pt-2 pb-4">

    <div class="row">
        <div class="col-md-9">
            @include('Blog::partials._articles')
        </div>

        <div class="col-md-3">
            @include('Blog::partials._sidebar')
        </div>

    </div>
</div>
@endsection
