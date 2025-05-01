<?php

declare(strict_types=1);

namespace Xetaravel\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $id = null,
        public ?string $value = null,
        public ?string $light = "Light",
        public ?string $dark = "Dark",
        public ?string $lightTheme = "light",
        public ?string $darkTheme = "dark",
        public ?string $lightClass = "light",
        public ?string $darkClass = "dark",
        public ?bool $withLabel = false,
    ) {
        $this->uuid = md5(serialize($this)) . $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.theme-toggle');
    }
}
