<footer class="footer footer-center p-10 bg-base-200 dark:bg-base-300 dark:text-slate-300 text-left">
    <div class="lg:container lg:text-center w-full mx-auto">
        <div class="w-full">
            &copy; {{ date('Y', time()) }} {{ config('app.name') }}. All rights reserved.
        </div>
        <div class="w-full">
            <i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-heart" style="color: #fa6c65"></i> and <i class="fa fa-coffee" style="color: #826644"></i> by <a href="https://github.com/Xety" target="_blank" class="link link-hover link-primary">@Emeric</a>
        </div>
        <div class="w-full">
            Hosted with <a href="https://forge.laravel.com" target="_blank" class="link link-hover link-primary">Laravel Forge</a> and <a href="https://www.digitalocean.com" target="_blank" class="link link-hover link-primary">DigitalOcean</a>
        </div>
    </div>
</footer>
