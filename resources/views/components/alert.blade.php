
<div {{ $attributes->merge(['class' => 'flex w-full overflow-hidden rounded-lg shadow-md bg-white dark:bg-base-200 z-10']) }}>

    @if ($type == "error")
    <div class="flex items-center justify-center w-14 bg-red-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path></svg>
    </div>
    <div class="px-2 py-2 w-full relative">
        <div class="mx-3">
            <span class="font-semibold text-red-500">{{ isset($title) ? $title : 'Erreur' }}</span>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
@elseif ($type == "success")
    <div class="flex items-center justify-center w-14 bg-green-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"></path></svg>
    </div>
    <div class="relative px-2 py-2 w-full">
        <div class="mx-3">
            <span class="font-semibold text-green-500">{{ isset($title) ? $title : 'Succès' }}</span>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
@elseif ($type == "info")
    <div class="flex items-center justify-center w-12 bg-blue-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path></svg>
    </div>
    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-blue-500">{{ isset($title) ? $title : 'Information' }}</span>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
@elseif ($type == "warning")
    <div class="flex items-center justify-center w-12 bg-yellow-500">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path></svg>
    </div>
    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-semibold text-yellow-500">{{ isset($title) ? $title : 'Attention' }}</span>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
@elseif ($type == "primary")
    <div class="flex items-center justify-center w-14 bg-primary">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path></svg>
    </div>
    <div class="px-2 py-2 w-full relative">
        <div class="mx-3">
            <span class="font-semibold text-primary">{{ isset($title) ? $title : 'Information' }}</span>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
@endif
</div>
