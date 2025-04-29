<?php

declare(strict_types=1);

namespace Xetaravel\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Markdown extends Component
{
    public string $uuid;

    public string $uploadUrl = '';

    public function __construct(
        public ?string $value = null,
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $hintClass = 'fieldset-label',
        public ?string $disk = 'public',
        public ?string $folder = 'markdown',
        public ?array $config = [],

        // Validations
        public ?string $errorClass = 'text-error',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = md5(serialize($this));
        //$this->uploadUrl = route('upload', absolute: false);
    }

    public function setup(): string
    {
        $setup = array_merge([
            'spellChecker' => false,
            'autoSave' => false,
            'uploadImage' => false,
            'imageAccept' => 'image/png, image/jpeg',
            'toolbar' => [
                'heading', 'bold', 'italic', 'strikethrough', '|',
                'code', 'quote', 'unordered-list', 'ordered-list', 'horizontal-rule', '|',
                'link', 'table', '|',
                'preview', 'side-by-side'
            ],
            //'forceSync' => true
        ], $this->config);

        // Table default CSS class `.table` breaks the layout.
        // Here is a workaround
        $table = "{ 'title' : 'Table', 'name' : 'myTable', 'action' : EasyMDE.drawTable, 'className' : 'fa fa-table' }";

        return str(json_encode($setup))
            ->replace("\"", "'")
            ->trim('{}')
            ->replace("'table'", $table)
            ->toString();
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->modelName() ?? $this->attributes->whereStartsWith('name')->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.markdown');
    }
}
