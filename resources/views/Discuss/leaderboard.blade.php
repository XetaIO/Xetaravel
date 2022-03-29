@extends('layouts.app')
{!! config(['app.title' => 'Leaderboard']) !!}

@section('content')
<div class="container pt-6 pb-0">
    {!! $breadcrumbs->render() !!}
</div>
<div class="container pt-2">

    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-module">
                <div class="discuss-new-discussion-btn text-truncate">
                    {{ link_to(
                        route('discuss.conversation.create'),
                        '<i class="fa fa-pencil"></i> Start a Discussion',
                        ['class' => 'btn btn-primary'],
                        true,
                        false
                    ) }}
                </div>

                @include('Discuss::partials._sidebar')
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb text-md-center">
                        <h5 class="mb-0">
                                Community Pillar
                        </h5>
                    </div>
                </div>

                @php
                    $i = 0;
                @endphp

                @foreach ($users as $user)
                    @php
                        $i++;
                    @endphp

                    @if ($i == 4)
                        <div class="col-md-12">
                            <div class="breadcrumb mt-4 text-md-center">
                                <h5 class="mb-0">
                                        The most active in the Community
                                </h5>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4">
                        <div class="leaderboard">
                            <span class="leaderboard-number">
                                <b>{{ $i }}</b>
                            </span>
                            <div class="leaderboard-body">
                                <a href="{{ $user->profile_url }}" style="position: relative;">
                                    <img src="{{ $user->avatar_small }}" alt="{{ $user->username }}"  class="leaderboard-body-image img-thumbnail {{ $badge->icon }}" style="height:100px; width:100px; {{ $i <=3 ? "border-color: #f7a925;" : ""}}"/>
                                    @if ($i <= 3)
                                        <i aria-hidden="true" class="fas fa-medal leaderboard-body-badge"  data-toggle="popover" data-trigger="hover" data-placement="top" title="{{ $badge->name }}" data-content="{{ $badge->description }}"></i>
                                    @endif
                                </a>
                                <h5 class="leaderboard-user">
                                    {{ $user->username }}
                                </h5>
                                <div class="leaderboard-infos">
                                    <div class="leaderboard-text text-muted">
                                        <h5 class="leaderboard-text-title" style="{{ $i <= 3 ? "color:#f7a925" : "" }}">
                                            {{ $user->experiences_total }}
                                        </h5>
                                        Experience
                                    </div>
                                    <div class="leaderboard-text text-muted">
                                        <h5 class="leaderboard-text-title" style="{{ $i <= 3 ? "color:#f7a925" : "" }}">
                                            {{ $user->discuss_post_count }}
                                        </h5>
                                        Posts
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection