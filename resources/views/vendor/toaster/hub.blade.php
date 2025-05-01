<div role="status" id="toaster" x-data="toasterHub(@js($toasts), @js($config))" @class([
    'fixed z-50 p-4 w-full flex flex-col pointer-events-none sm:p-6',
    'bottom-14' => $alignment->is('bottom'),
    'top-1/2 -translate-y-1/2' => $alignment->is('middle'),
    'top-14' => $alignment->is('top'),
    'items-start rtl:items-end' => $position->is('left'),
    'items-center' => $position->is('center'),
    'items-end rtl:items-start' => $position->is('right'),
 ])>
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.isVisible"
             x-init="$nextTick(() => toast.show($el))"
             @if($alignment->is('bottom'))
                 x-transition:enter-start="translate-y-12 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             @elseif($alignment->is('top'))
                 x-transition:enter-start="-translate-y-12 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             @else
                 x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             @endif
             x-transition:leave-end="opacity-0 scale-90"
            @class(['flex rounded-lg shadow-md bg-white dark:bg-base-300 relative duration-300 transform transition ease-in-out w-full max-w-sm pointer-events-auto', 'text-center' => $position->is('center')])
        >
            <div
                class="flex items-center justify-center rounded-l-lg w-16"
                :class="toast.select({ error: 'bg-red-500', info: 'bg-blue-500', success: 'bg-green-500', warning: 'bg-yellow-500' })"
                x-html='
                toast.select({
                    error: "<svg class=\"w-6 h-6 text-white fill-current\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z\"></path></svg>",
                    info: "<svg class=\"w-6 h-6 text-white fill-current\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z\"></path></svg>",
                    success: "<svg class=\"w-6 h-6 text-white fill-current\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z\"></path></svg>",
                    warning: "<svg class=\"w-6 h-6 text-white fill-current\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z\"></path></svg>"
            })'
            ></div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span
                        class="font-semibold  select-none"
                        :class="toast.select({ error: 'text-red-500', info: 'text-blue-500', success: 'text-green-500', warning: 'text-yellow-500' })"
                        x-text="toast.select({ error: 'Error', info: 'information', success: 'Success', warning: 'Warning' })"
                    ></span>
                    <p class="text-sm" x-html="toast.message"></p>
                </div>
            </div>

            @if($closeable)
                <button @click="toast.dispose()" aria-label="@lang('close')" class="absolute right-0 p-2 focus:outline-none cursor-pointer rtl:right-auto rtl:left-0 {{ $alignment->is('bottom') ? 'top-3' : 'top-0' }}">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            @endif
        </div>
    </template>
</div>
