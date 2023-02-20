@extends('layouts.app')
{!! config(['app.title' => 'My notifications']) !!}

@push('meta')
  <x-meta title="My notifications" />
@endpush

@section('content')
<section class="lg:container mx-auto mt-12 mb-5">
    <div class="grid grid-cols-1">
        <div class="col-span-12 mx-3 lg:mx-0">
            {!! $breadcrumbs->render() !!}
        </div>
    </div>
</section>

<section class="lg:container mx-auto pt-4 mb-5">
    <div class="grid grid-cols-12 gap-8">

        <div class="lg:col-span-3 col-span-12 mx-3 lg:mx-0">
            @include('partials.user._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                <h2 class="divider text-2xl font-xetaravel">
                    Notifications
                </h2>

                @if ($notifications->isNotEmpty())
                    <users-notifications
                        :notifications="{{ json_encode($notifications->items()) }}"
                        :route-delete-notification="{{ var_export(route('users.notification.delete')) }}">
                    </users-notifications>

                    <div class="col-md 12 text-xs-center">
                        {{ $notifications->render() }}
                    </div>
                @else
                    You don't have any notifications.
                @endif

            </section>


            @if ($newsletter)
                <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                    <h2 class="divider text-2xl font-xetaravel">
                        Newsletter
                    </h2>
                    <p class="mb-6">
                        You are subscribed to the Newsletter with the email <code class="bg-base-200 dark:bg-base-100 p-1 rounded">{{ $newsletter->email }}</code> since : <code class="bg-base-200 dark:bg-base-100 p-1 rounded">{{ $newsletter->created_at->formatLocalized('%d %B %Y - %T') }}</code>.
                    </p>
                    <div class="text-center">
                        <a class="btn btn-error gap-2" href="{{ route('newsletter.unsubscribe', $newsletter->email) }}">
                            <i class="fa-solid fa-xmark"></i>
                            Unsubscribe
                        </a>
                    </div>

                </section>
            @endif

        </div>
    </div>
</section>
@endsection
