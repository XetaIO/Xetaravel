<?php

declare(strict_types=1);

namespace Xetaravel\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class DatePicker extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $hintClass = 'fieldset-label',
        public ?bool $inline = false,
        public ?array $config = [],

        // Slots
        public mixed $prepend = null,
        public mixed $append = null,

        // Validations
        public ?string $errorField = null,
        public ?string $errorClass = 'text-error',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = md5(serialize($this)) . $id;
    }

    public function setup(): string
    {
        // Handle `wire:model.live` for `range` dates
        if (isset($this->config["mode"]) && $this->config["mode"] === "range" && $this->attributes->wire('model')->hasModifier('live')) {
            $this->attributes->setAttributes([
                'wire:model' => $this->modelName(),
                'live' => true
            ]);
        }

        $config = json_encode(array_merge([
            'dateFormat' => 'Y-m-d H:i',
            'enableTime' => true,
            'disableMobile' => true,
            'minuteIncrement' => 1,
            //'altInput' => true,
            //'altInputClass' => ' ',
            'allowInput' => true,
            'time_24hr' => true,
            'clickOpens' => ! $this->attributes->has('readonly') || $this->attributes->get('readonly') === false,
            'defaultDate' => '#model#',
            'plugins' => ['#plugins#'],
            'disable' => ['#disable#'],
        ], Arr::except($this->config, ["plugins"])));

        // Plugins
        $plugins = "";

        foreach (Arr::get($this->config, 'plugins', []) as $plugin) {
            $plugins .= "new " . key($plugin) . "( " . json_encode(current($plugin)) . " ),";
        }

        $config = str_replace('"#plugins#"', $plugins, $config);

        // Disables
        $disables = '';

        foreach (Arr::get($this->config, 'disable', []) as $disable) {
            $disables .= $disable . ',';
        }

        $config = str_replace('"#disable#"', $disables, $config);

        // Sets default date as current bound model
        return str_replace('"#model#"', '$wire.get("' . $this->modelName() . '")', $config);
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->errorField ?? $this->modelName();
    }

    public function isReadonly(): bool
    {
        return $this->attributes->has('readonly') && $this->attributes->get('readonly') === true;
    }

    public function isDisabled(): bool
    {
        return $this->attributes->has('disabled') && $this->attributes->get('disabled') === true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.date-picker');
    }
}
