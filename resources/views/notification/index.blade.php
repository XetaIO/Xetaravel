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
            <section>
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
        </div>
    </div>
</div>
@endsection
