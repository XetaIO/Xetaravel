@extends('layouts.app')
{!! config(['app.title' => 'My notifications']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            @include('partials.user._sidebar')
        </div>
        <div class="col-md-9">
            <section>

                @if ($notifications->isNotEmpty())
                    <users-notifications
                        :notifications="{{ json_encode($notifications->items()) }}"
                        :route-delete-notification="{{ var_export(route('users.notification.delete', ['id' => ''])) }}">
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
