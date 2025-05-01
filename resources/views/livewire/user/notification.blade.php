<div>
    <div class="dropdown dropdown-end">
        <!-- Toggle notification menu -->
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <span x-text="$wire.unreadNotificationsCount" class="badge badge-sm indicator-item badge-primary {{ $hasUnreadNotifications && $notifications->isNotEmpty() ? '' : 'hidden' }}"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 grid place-items-center {{ $hasUnreadNotifications && $notifications->isNotEmpty() ? 'animate-ringing' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            </div>
        </label>

        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-96 bg-base-100 shadow z-50">
            <div class="card-body">
                <h3 class="card-title  justify-center">
                    Notifications
                </h3>

                <div class="divider my-0"></div>

                <ul class="max-h-[350px] overflow-y-scroll">
                    @forelse($notifications as $notification)
                        <li class="flex items-center rounded mb-3 mr-2 py-2 hover:bg-slate-200 dark:hover:hover:bg-base-content/10" wire:key="{{ $notification->id }}">
                            <div class="indicator w-full">
                                <!-- URL -->
                                <a
                                    @if($notification->read_at == null) wire:mouseover.prevent="markAsRead('{{ $notification->id }}')" @endif
                                    class="px-3 flex items-center"
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

                                    <!-- Badge new -->
                                    @if($notification->read_at == null)
                                        <span class="badge badge-sm indicator-item badge-primary right-3 z-10">New</span>
                                    @endif

                                </a>
                            </div>
                            <!-- Delete icon -->
                            <a wire:click="remove('{{ $notification->id }}')" class="cursor-pointer tooltip tooltip-left" data-tip="Delete the notification">
                                <x-icon name="fas-trash-can" class="h-6 w-6 text-error mr-3"></x-icon>
                            </a>
                        </li>
                    @empty
                        <li>
                            <p class="m-2 text-center">
                                You don't have notifications
                            </p>
                        </li>
                    @endforelse
                </ul>

                <!-- Mark all as read -->
                @if($hasUnreadNotifications && $notifications->isNotEmpty())
                    <div class="mb-1">
                        <div class="divider my-0"></div>
                        <x-button wire:click="markAllNotificationsAsRead" label="Mark all notifications as read" icon="fas-check" icon-classes="h-6 w-6" class="w-full" link />
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
