<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Xetaravel\Models\BlogCategory;

class BlogCategoryForm extends Form
{
    /**
     * The category to update.
     *
     * @var BlogCategory|null
     */
    public ?BlogCategory $blogCategory = null;

    /**
     * The title of the category.
     *
     * @var string|null
     */
    #[Validate('required|min:5')]
    public ?string $title = null;

    /**
     * The description of the category.
     *
     * @var string|null
     */
    #[Validate('required|min:10')]
    public ?string $description = null;

    /**
     * Function to store the model.
     *
     * @return BlogCategory
     */
    public function create(): BlogCategory
    {
        $properties = [
            'title',
            'description'
        ];

        return BlogCategory::create($this->only($properties));
    }

    /**
     * Function to update the model.
     *
     * @return BlogCategory
     */
    public function update(): BlogCategory
    {
        $this->blogCategory->title = $this->title;
        $this->blogCategory->description = $this->description;
        $this->blogCategory->save();

        return $this->blogCategory;
    }
}
