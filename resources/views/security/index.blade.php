@extends('layouts.app')
{!! config(['app.title' => 'Security']) !!}

@push('meta')
  <x-meta title="Security" />
@endpush

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
            <section class="mb-3">
                <div class="hr-divider">
                    <h4 class="hr-divider-content hr-divider-heading font-xeta">
                        Sessions
                    </h4>
                </div>
                <p>
                    This is a list of devices that are logged into your account.
                </p>

               <ul class="security-sessions">
                @foreach ($sessions as $session)
                    <li class="security-sessions-item {{ $sessionId == $session->id ? 'current' : '' }}">
                                <span class="online"></span>

                                <span class="icon" data-toggle="tooltip" data-container="body" title="{{ $session->user_agent }}">
                                    @if ($session->infos['desktop'] === true)
                                        <i class="fa fa-desktop fa-2x"></i>
                                    @elseif ($session->infos['phone'] === true)
                                        <i class="fa fa-mobile fa-2x"></i>
                                    @elseif ($session->infos['tablet'] === true)
                                        <i class="fa fa-tablet fa-2x"></i>
                                    @else
                                        <i class="fa fa-desktop fa-2x"></i>
                                    @endif
                                </span>

                                <div class="details">
                                    <p>
                                        <strong class="title">
                                            @if ($sessionId == $session->id)
                                                Your current session
                                            @else
                                                Other session
                                            @endif
                                            <span>{{ $session->ip_address }}</span>
                                        </strong>
                                    </p>

                                    <p>
                                        <strong>{{ $session->infos['browser'] }} {{ $session->infos['browser_version'] }}</strong>
                                        on {{ $session->infos['platform'] }} {{ $session->infos['platform_version'] }}
                                    </p>

                                    <p>
                                        <strong>Last seen on</strong>
                                        {{ $session->url }}
                                    </p>

                                    <p>
                                        <strong>Last seen</strong>
                                        {{ $session->updated_at->formatLocalized('%d %B %Y - %T') }}
                                    </p>

                                    <p>
                                        <strong>Created</strong>
                                        {{ $session->created_at->formatLocalized('%d %B %Y - %T') }}
                                    </p>
                                </div>
                            </li>

                @endforeach
               </ul>
            </section>

        </div>
    </div>
</div>
@endsection
