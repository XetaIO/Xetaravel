@extends('layouts.admin')
{!! config(['app.title' => 'Dashboard']) !!}

@push('meta')
    <x-meta title="Dashboard" />
@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-primary text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Members
                    </div>
                    <div>
                        <x-icon name="fas-users" class="h-8 w-8 opacity-50" />
                    </div>
                </div>

                <div class="text-4xl font-bold">
                    {{ $usersCount }}
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    The numbers of users registered since the beginning.
                </span>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-[color:#00acac] text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Articles
                    </div>
                    <div>
                        <x-icon name="far-newspaper" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $articlesCount }}
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    The numbers of articles published since the beginning.
                </span>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-[color:#727cb6] text-white shadow-md h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Comments
                    </div>
                    <div>
                        <x-icon name="far-message" class="h-8 w-8 opacity-50" />
                    </div>
                </div>
                <div class="text-4xl font-bold">
                    {{ $commentsCount }}
                </div>
                <div class="divider"></div>
                <span class="opacity-70">
                    The numbers of comments created since the beginning.
                </span>
            </div>
        </div>

        @if (!App::environment('testing') && settings('analytics_enabled'))
            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="p-6 rounded-lg bg-[color:#348fe2] text-white shadow-md h-full">
                    <div class="flex justify-between">
                        <div class="text-2xl uppercase">
                            Yesterday's visits
                        </div>
                        <div>
                            <x-icon name="fas-globe" class="h-8 w-8 opacity-50" />
                        </div>
                    </div>
                    <div class="text-4xl font-bold">
                        {{ $yesterdayVisitors->first()['screenPageViews'] }}
                    </div>
                    <div class="divider"></div>
                    <span class="opacity-70">
                        The numbers of visits for yesterday.
                    </span>
                </div>
            </div>
        @endif
    </div>

    @if (!App::environment('testing') && settings('analytics_enabled'))
        @include('Admin::partials.page._analytics')

        @include('Admin::partials.page._analytics-scripts')
    @endif

</section>
@endsection
