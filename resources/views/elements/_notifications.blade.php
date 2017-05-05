<div class="dropdown navbar-notifications float-xs-right pr-1">
    <a class="dropdown-toggle"
        {!! $hasUnreadNotifications ? 'data-number="(' . $unredNotificationsCount . ')"' : '' !!}
    href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon fa fa-bell-o {{ $hasUnreadNotifications ? 'animated infinite ringing' : 'text-body' }}"></i>
    </a>
    
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
        <h6 class="dropdown-header text-xs-center">
            News Notifications
        </h6>
        <div class="dropdown-divider mb-0"></div>

        @if ($notifications->isNotEmpty())
            @foreach ($notifications as $notification)
                <a class="dropdown-item" href="#">
                    <!-- Image -->
                    @if (isset($notification->data['image']))
                        <img src="{{ asset($notification->data['image']) }}" alt="Image">
                    @else
                        <img src="{{ asset('images/logo.svg') }}" alt="Image">
                    @endif

                    <!-- Message -->
                    <span class="message">
                        @if (isset($notification->data['message_key']))
                            {!! sprintf($notification->data['message'], $notification->data['message_key']) !!}
                        @else
                            {!! $notification->data['message'] !!}
                        @endif
                    </span>

                    <!-- Read -->
                    @if ($notification->unread())
                        <strong class="new">
                            <span></span>
                            New
                        </strong>
                    @endif
                
                </a>
            @endforeach
        @else
            <p class="dropdown-item mb-0 text-xs-center">
                You don't have any notifications.
            </p>
        @endif
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-xs-center" href="#">
            All Notifications
        </a>
    </div>
</div>