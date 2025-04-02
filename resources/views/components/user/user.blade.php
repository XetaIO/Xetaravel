<div class="dropdown dropdown-hover dropdown-top dropdown-middle !aspect-auto">
    <label tabindex="0" class="text-primary font-bold cursor-pointer">
        {{ $userName }}
    </label>
    <div tabindex="0" class="dropdown-content card card-compact shadow bg-base-100 rounded-box min-w-fit">
        <div class="card-body flex flex-row">
            <div class="avatar">
                <div class="w-24 rounded-full ring ring-[color:#fff]">
                    <img src="{{ asset($userAvatarSmall) }}" alt="{{ $userName }} Avatar">
                </div>
            </div>
            <div class="flex flex-col justify-around  min-w-[250px] ml-2">
                <div class="card-title truncate">
                    <a href="{{ $userProfile }}" class="text-primary">{{ $userName }}</a>
                </div>
                <ul class="flex">
                    <li data-tip="Last seen" class="tooltip">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $userLastLogin }}
                    </li>
                    <li data-tip="Registered" class="tooltip ml-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block align-text-top"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"></path></svg>
                        {{ $userRegistered }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
