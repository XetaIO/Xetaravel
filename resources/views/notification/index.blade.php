@extends('layouts.app')
{!! config(['app.title' => 'My notifications']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('account._sidebar')
        </div>
        <div class="col-md-9">
            <section>
                @if ($notifications->isNotEmpty())
                    @if ($hasUnreadNotifications)
                        <button class="btn btn-sm btn-outline-primary mark-all-notifications-as-read text-xs-center" data-url="{{ route('users_notification_markallasread') }}">
                            <i class="fa fa-check" aria-hidden="true"></i> Mark all notifications as read
                        </button>
                    @endif
                    
                    <table class="table table-hover table-notifications">
                        @foreach ($notifications as $notification)
                            <tr class="alert notification-item" id="notification-{{ $notification->id }}">
                                <td style="position: relative;">
                                     <!-- Image -->
                                    @if (isset($notification->data['image']))
                                        <img src="{{ asset($notification->data['image']) }}" alt="Image" width="60">
                                    @else
                                        <img src="{{ asset('images/logo.svg') }}" alt="Image" width="60">
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

                                    <!-- Delete -->
                                    <button type="button" class="close text-danger delete-notification" data-toggle="tooltip" title="Delete this notification" data-dismiss="alert" aria-label="Close" data-id="{{ $notification->id }}" data-url="{{ route('users_notification_delete') }}">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    
                    <div class="col-md 12 text-xs-center">
                        {{ $notifications->render() }}
                    </div>
                @else
                    You don't have any notifications.
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
