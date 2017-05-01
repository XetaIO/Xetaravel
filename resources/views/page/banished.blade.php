@extends('layouts.app')
{!! config(['app.title' => 'You\'re banished']) !!}

@section('content')
<div class="container pt-6">
    <div class="text-xs-center">
        <h1 class="font-xeta text-primary animated flash">
            You're banished !
        </h1>
    </div>
    <div class="text-xs-center pt-5">
        <img src="{{ asset('images/hippo.png') }}"  width="350">
    </div>
</div>
<audio preload="auto" autobuffer controls autoplay="autoplay" id="pacman" style="opacity: 0">
	<source src="{{ asset('music/Pacman.mp3') }}" type="audio/mpeg" />
	<source src="{{ asset('music/Pacman.ogg') }}" type="audio/ogg" />
	<source src="{{ asset('music/Pacman.wav') }}" type="audio/wav" />
</audio>
@endsection

@push('scripts')
    <script type="text/javascript">
        var pacman = document.getElementById('pacman');
        pacman.volume = 0.5;
    </script>
@endpush