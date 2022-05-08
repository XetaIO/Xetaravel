@extends('layouts.app')
{!! config(['app.title' => 'My notifications']) !!}

@push('meta')
  <x-meta title="My notifications" />
@endpush

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2 pb-4">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section class="section mb-3">
                <div class="hr-divider">
                    <div class="hr-divider-content hr-divider-heading font-xeta">
                        Notifications
                    </div>
                </div>

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
                <section>
                    <div class="hr-divider">
                        <div class="hr-divider-content hr-divider-heading font-xeta">
                            Newsletter
                        </div>
                    </div>
                    <p>
                        You are subscribed to the Newsletter with the email <code>{{ $newsletter->email }}</code> since : <code>{{ $newsletter->created_at->formatLocalized('%d %B %Y - %T') }}</code>.
                    </p>
                    <div class="text-xs-center">
                        {{ link_to(route('newsletter.unsubscribe', $newsletter->email), '<i class="fa fa-remove"></i> Unsubscribe', ['class' => 'btn btn-outline-danger'], null, false) }}
                    </div>

                </section>
            @endif

        </div>
    </div>
</div>
@endsection
