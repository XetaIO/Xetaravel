<x-layouts.app>
    <x-slot:title>
        You're banished
    </x-slot:title>

    <x-slot:meta>
        <x-meta title="You're banished" />
    </x-slot:meta>

    @push('scripts')
        <script type="text/javascript">
            const pacman = document.getElementById('pacman');
            pacman.volume = 0.5;
        </script>
    @endpush

    <section class="lg:container mx-auto mt-12 mb-5">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-error">
                You're banished !
            </h1>
        </div>
        <div class="text-center pt-5">
            <img class="max-w-sm mx-auto" src="{{ asset('images/hippo.png') }}" title="Banished logo" alt="Banished logo">
        </div>
    </section>
    <audio preload="auto" autobuffer controls autoplay="autoplay" id="pacman" style="opacity: 0">
        <source src="{{ asset('music/Pacman.mp3') }}" type="audio/mpeg" />
        <source src="{{ asset('music/Pacman.ogg') }}" type="audio/ogg" />
        <source src="{{ asset('music/Pacman.wav') }}" type="audio/wav" />
    </audio>
</x-layouts.app>
