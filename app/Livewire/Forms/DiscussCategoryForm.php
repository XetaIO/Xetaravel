<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Xetaravel\Models\DiscussCategory;

class DiscussCategoryForm extends Form
{
    /**
     * The category to update.
     *
     * @var DiscussCategory|null
     */
    public ?DiscussCategory $discussCategory = null;

    /**
     * The title of the category.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * The color of the category.
     *
     * @var string|null
     */
    public ?string $color = null;

    /**
     * The icon of the category.
     *
     * @var string|null
     */
    public ?string $icon = null;

    /**
     * The level of the category.
     *
     * @var string|null
     */
    public ?string $level = null;

    /**
     * Whatever the category is locked.
     *
     * @var bool|null
     */
    public ?bool $is_locked = false;

    /**
     * The description of the category.
     *
     * @var string|null
     */
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'title' => 'required|min:5',
            'color' => 'required|min:7|max:7|hex_color',
            'icon' => 'required|min:3',
            'level' => [
                'required',
                'integer',
                Rule::unique('discuss_categories')->ignore($this->discussCategory)
            ],
            'is_locked' => 'required|bool',
            'description' => 'required|min:10',
        ];
    }

    /**
     * Function to store the model.
     *
     * @return DiscussCategory
     */
    public function create(): DiscussCategory
    {
        $properties = [
            'title',
            'color',
            'icon',
            'level',
            'is_locked',
            'description'
        ];

        return DiscussCategory::create($this->only($properties));
    }

    /**
     * Function to update the model.
     *
     * @return DiscussCategory
     */
    public function update(): DiscussCategory
    {
        $this->discussCategory->title = $this->title;
        $this->discussCategory->color = $this->color;
        $this->discussCategory->icon = $this->icon;
        $this->discussCategory->level = $this->level;
        $this->discussCategory->is_locked = $this->is_locked;
        $this->discussCategory->description = $this->description;
        $this->discussCategory->save();

        return $this->discussCategory;
    }
}
