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
            @include('user.partials._sidebar')
        </div>

        <div class="lg:col-span-9 col-span-12 mx-3 lg:mx-0">
            <section class="rounded-lg bg-base-100 dark:bg-base-300 shadow-md py-4 px-8 mb-10">
                <h2 class="divider text-2xl">
                    Notifications
                </h2>

                @if ($notifications->isNotEmpty())
                    <ul>
                        @forelse($notifications as $notification)
                            <li class="flex items-center rounded mb-3 mr-2 py-2 hover:bg-slate-200 dark:hover:hover:bg-base-content/10">
                                <!-- URL -->
                                <a
                                    @if($notification->read_at == null) wire:mouseover.prevent="markAsRead('{{ $notification->id }}')" @endif
                                    class="px-3 flex items-center w-full"
                                    href="{{ $notification->data['link'] }}"
                                >
                                    <!-- Icon -->
                                    @if($notification->type == \Xetaravel\Notifications\BadgeNotification::class)
                                        <x-icon name="{{ $notification->data['icon'] }}" class="h-10 w-10 mr-3" style="color:{{ $notification->data['color'] }}"></x-icon>
                                    @elseif($notification->type == \Xetaravel\Notifications\MentionNotification::class)
                                        <x-icon name="fas-at" class="h-10 w-10 text-error mr-3"></x-icon>
                                    @else
                                        <x-icon name="fas-triangle-exclamation" class="h-10 w-10 text-error mr-3"></x-icon>
                                    @endif

                                    <!-- Message -->
                                    <span class="w-full">
                                        {!! $notification->data['message'] !!}
                                    </span>
                                </a>
                                <!-- Delete icon -->
                                <x-form method="delete" action="{{ route('user.notification.delete', ['slug' => $notification->id]) }}">
                                    <x-button type="submit" icon="fas-trash-can" icon-classes="h-6 w-6 text-error" data-tip="Delete the notification" class="btn-ghost cursor-pointer tooltip tooltip-left gap-2" />
                                </x-form>
                            </li>
                        @empty
                            <li>
                                <p class="m-2 text-center">
                                    You don't have notifications
                                </p>
                            </li>
                        @endforelse
                    </ul>

                    <div class="col-md 12 text-xs-center">
                        {{ $notifications->render() }}
                    </div>
                @else
                    You don't have any notifications.
                @endif
            </section>

            @if ($newsletter)
                <section class="border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700 py-4 px-8 mb-10">
                    <h2 class="divider text-2xl">
                        Newsletter
                    </h2>
                    <p class="mb-6">
                        You are subscribed to the Newsletter with the email <code class="bg-base-200 dark:bg-base-100 p-1 rounded">{{ $newsletter->email }}</code> since : <code class="bg-base-200 dark:bg-base-100 p-1 rounded">{{ $newsletter->created_at->isoFormat('lll') }}</code>.
                    </p>
                    <div class="text-center">
                        <a class="btn btn-error gap-2" href="{{ route('newsletter.unsubscribe', $newsletter->email) }}">
                            <x-icon name="fas-xmark" />
                            Unsubscribe
                        </a>
                    </div>
                </section>
            @endif

        </div>
    </div>
</section>
@endsection
