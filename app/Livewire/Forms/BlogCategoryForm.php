<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Validation\Rule;
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
    public ?string $title = null;

    /**
     * The description of the category.
     *
     * @var string|null
     */
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:5',
                Rule::unique('blog_categories')->ignore($this->blogCategory)
            ],
            'description' => 'required|min:10',
        ];
    }

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
