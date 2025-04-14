<footer class="footer footer-horizontal footer-center p-10 bg-base-200 dark:bg-base-300 text-base-content">
    <div class="w-full mx-auto">
        <div class="w-full">
            &copy; {{ date('Y', time()) }} {{ config('app.name') }}. All rights reserved.
        </div>
        <div class="w-full">
            <x-icon name="fas-code" class="h-5 w-5 font-bold inline"></x-icon> with
            <x-icon name="fas-heart" class="h-4 w-4 inline" style="color: #fa1212"></x-icon> and
            <x-icon name="fas-coffee" class="h-5 w-5 inline" style="color: #826644"></x-icon> by <a href="https://github.com/Xety" target="_blank" class="link link-hover link-primary">@Emeric</a>
        </div>
        <div class="w-full">
            Hosted with <a href="https://forge.laravel.com" target="_blank" class="link link-hover link-primary">Laravel Forge</a> and <a href="https://www.digitalocean.com" target="_blank" class="link link-hover link-primary">DigitalOcean</a>
        </div>
    </div>
</footer>
