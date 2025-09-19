<?php

declare(strict_types=1);

namespace Xetaravel\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $hintClass = 'fieldset-label',
        public ?bool $hideProgress = false,
        public ?bool $cropAfterChange = false,
        public ?string $changeText = "Change",
        public ?string $cropTitleText = "Crop image",
        public ?string $cropCancelText = "Cancel",
        public ?string $cropSaveText = "Crop",
        public ?array $cropConfig = [],
        public ?string $cropMimeType = "image/png",

        // Validations
        public ?string $errorClass = 'text-error',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = md5(serialize($this)) . $id;
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->modelName() ?? $this->attributes->whereStartsWith('name')->first();
    }

    public function cropSetup(): string
    {
        return json_encode(array_merge([
            'autoCropArea' => 1,
            'viewMode' => 1,
            'dragMode' => 'move'
        ], $this->cropConfig));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.file');
    }
}
