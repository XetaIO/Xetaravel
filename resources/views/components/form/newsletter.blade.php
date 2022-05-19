
        <input name="email" type="email" required placeholder="email@gmail.com" class="input input-bordered w-full pr-16" />
        <button type="submit" class="absolute bg-primary text-white px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs ease-linear transition-all duration-150 hover:text-primary hover:bg-white right-0 top-2 gap-1">
            <svg xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4 fill-current" viewBox="0 0 512 512"><path d="M501.6 4.186c-7.594-5.156-17.41-5.594-25.44-1.063L12.12 267.1C4.184 271.7-.5037 280.3 .0431 289.4c.5469 9.125 6.234 17.16 14.66 20.69l153.3 64.38v113.5c0 8.781 4.797 16.84 12.5 21.06C184.1 511 188 512 191.1 512c4.516 0 9.038-1.281 12.99-3.812l111.2-71.46l98.56 41.4c2.984 1.25 6.141 1.875 9.297 1.875c4.078 0 8.141-1.031 11.78-3.094c6.453-3.625 10.88-10.06 11.95-17.38l64-432C513.1 18.44 509.1 9.373 501.6 4.186zM369.3 119.2l-187.1 208.9L78.23 284.7L369.3 119.2zM215.1 444v-49.36l46.45 19.51L215.1 444zM404.8 421.9l-176.6-74.19l224.6-249.5L404.8 421.9z"/></svg>
            Subscribe
        </button>

    @if ($errors->has($name))
    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
        <span class="font-medium">Oops!</span>
        {{ $errors->first($name) }}
    </p>
    @endif