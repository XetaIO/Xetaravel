@extends('layouts.admin')
{!! config(['app.title' => 'Dashboard']) !!}

@push('meta')
    <x-meta title="Dashboard" />
@endpush

@section('content')
<section class="m-3 lg:m-10">
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 lg:col-span-6 xl:col-span-3">
            <div class="p-6 rounded-lg bg-primary text-white h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Members
                    </div>
                    <div>
                        <i class="fa-solid fa-users opacity-50 text-5xl"></i>
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
            <div class="p-6 rounded-lg bg-[color:#00acac] text-white h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Articles
                    </div>
                    <div>
                        <i class="fa-regular fa-newspaper opacity-50 text-5xl"></i>
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
            <div class="p-6 rounded-lg bg-[color:#727cb6] text-white h-full">
                <div class="flex justify-between">
                    <div class="text-2xl uppercase">
                        Comments
                    </div>
                    <div>
                        <i class="fa-regular fa-message opacity-50 text-5xl"></i>
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

        @if (config('analytics.enabled'))
            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="p-6 rounded-lg bg-[color:#348fe2] text-white h-full">
                    <div class="flex justify-between">
                        <div class="text-2xl uppercase">
                            Today's visits
                        </div>
                        <div>
                            <i class="fa-solid fa-globe opacity-50 text-5xl"></i>
                        </div>
                    </div>
                    <div class="text-4xl font-bold">
                        {{ $todayVisitors }}
                    </div>
                    <div class="divider"></div>
                    <span class="opacity-70">
                        The numbers of visits for today.
                    </span>
                </div>
            </div>
        @endif
    </div>

    @if (config('analytics.enabled'))
        @include('Admin::partials.page._analytics')

        @push('script')
            @include('Admin::partials.page._analytics-scripts')
        @endpush
    @endif

</section>
@endsection