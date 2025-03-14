<?php

namespace Xetaravel\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Password extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $hintClass = 'fieldset-label',
        public ?string $prefix = null,
        public ?string $suffix = null,
        public ?bool $inline = false,
        public ?bool $clearable = false,

        // Password
        public ?string $passwordIcon = 'heroicon-o-eye-slash',
        public ?string $passwordVisibleIcon = 'heroicon-o-eye',
        public ?bool $right = false,
        public ?bool $onlyPassword = false,

        // Slots
        public mixed $prepend = null,
        public mixed $append = null,

        // Validations
        public ?string $errorClass = 'text-error',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = md5(serialize($this));

        // Cannot use a left icon when password toggle should be shown on the left side.
        if (($this->icon && ! $this->right) && ! $this->onlyPassword) {
            throw new Exception("Cannot use `icon` without providing `right` or `onlyPassword`.");
        }

        // Cannot use a right icon when password toggle should be shown on the right side.
        if (($this->iconRight && $this->right) && ! $this->onlyPassword) {
            throw new Exception("Cannot use `iconRight` when providing `right` and not providing `onlyPassword`.");
        }
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->modelName() ?? $this->attributes->whereStartsWith('name')->first();
    }

    public function placeToggleLeft(): bool
    {
        return (! $this->icon && ! $this->right) && ! $this->onlyPassword;
    }

    public function placeToggleRight(): bool
    {
        return (! $this->iconRight && $this->right) && ! $this->onlyPassword;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.password');
    }
}
