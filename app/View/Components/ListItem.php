<?php

declare(strict_types=1);

namespace Xetaravel\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListItem extends Component
{
    public string $uuid;

    public function __construct(
        public object|array $item,
        public string $avatar = 'avatar',
        public string $value = 'name',
        public ?string $subValue = '',
        public ?bool $noSeparator = false,
        public ?bool $noHover = false,
        public ?string $link = null,

        // Slots
        public mixed $actions = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.list-item');
    }
}
