 <div class="grid {{ $user->roles()->count() >= 2 ? 'grid-cols-2' : 'grid-cols-1' }} gap-2">

    @if ($user->isMember())
        <div class="col-span-1">
            <x-badge.icon.member/>
        </div>
    @endif

    @if ($user->isModerator())
        <div class="col-span-1">
            <x-badge.icon.moderator/>
        </div>
    @endif

    @if ($user->isAdministrator())
        <div class="col-span-1">
            <x-badge.icon.administrator/>
        </div>
    @endif

    @if ($user->isDeveloper())
        <div class="col-span-1">
            <x-badge.icon.developer/>
        </div>
    @endif
</div>