 <div class="grid {{ $user->roles()->count() >= 2 ? 'grid-cols-2' : 'grid-cols-1' }} gap-2">

    @if ($user->hasRole('User'))
        <div class="col-span-1">
            <x-badge.icon.member/>
        </div>
    @endif

    @if ($user->hasRole('Moderator'))
        <div class="col-span-1">
            <x-badge.icon.moderator/>
        </div>
    @endif

    @if ($user->hasRole('Administrator'))
        <div class="col-span-1">
            <x-badge.icon.administrator/>
        </div>
    @endif

    @if ($user->hasRole('Developer'))
        <div class="col-span-1">
            <x-badge.icon.developer/>
        </div>
    @endif
</div>
