<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Xetaravel\Models\Badge;

class BadgeForm extends Form
{
    /**
     * The role to update.
     *
     * @var Badge|null
     */
    public ?Badge $badge = null;

    /**
     * The name of the badge.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The description of the badge.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * The icon of the badge.
     *
     * @var string|null
     */
    public ?string $icon = null;

    /**
     * The color of the badge.
     *
     * @var string|null
     */
    public ?string $color = null;

    /**
     * The type of the badge.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * The rule of the badge.
     *
     * @var int|null
     */
    public ?int $rule = null;


    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('badges')->ignore($this->badge)
            ],
            'description' => 'min:10',
            'icon' => 'required|string',
            'color' => 'required|min:7|max:7|hex_color',
            'type' => 'required|string',
            'rule' => [
                'required',
                'int',
                Rule::unique('badges')
                    ->ignore($this->badge)
                    ->where(function ($query) {
                        return $query->where('type', $this->type);
                    }),
            ],
        ];
    }

    /**
     * Function to store the model.
     *
     * @return Badge
     */
    public function create(): Badge
    {
        $properties = [
            'name',
            'description',
            'icon',
            'color',
            'type',
            'rule',
        ];

        return Badge::create($this->only($properties));
    }

    /**
     * Function to update the model.
     *
     * @return Badge
     */
    public function update(): Badge
    {
        $this->badge->update($this->only([
            'name',
            'description',
            'icon',
            'color',
            'type',
            'rule',
        ]));

        return $this->badge->fresh();
    }
}
