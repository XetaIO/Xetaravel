<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Form
{
    /**
     * The permission to update.
     *
     * @var Permission|null
     */
    public ?Permission $permission = null;

    /**
     * The name of the permission.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The description of the permission.
     *
     * @var string|null
     */
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:5',
                Rule::unique('permissions')->ignore($this->permission)
            ],
            'description' => 'required|min:10',
        ];
    }

    /**
     * Function to store the model.
     *
     * @return Permission
     */
    public function create(): Permission
    {
        $properties = [
            'name',
            'description'
        ];

        return Permission::create($this->only($properties));
    }

    /**
     * Function to update the model.
     *
     * @return Permission
     */
    public function update(): Permission
    {
        $this->permission->update($this->only([
            'name',
            'description'
        ]));

        return $this->permission->fresh();
    }
}
