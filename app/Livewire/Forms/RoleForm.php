<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    /**
     * The role to update.
     *
     * @var Role|null
     */
    public ?Role $role = null;

    /**
     * The name of the role.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The color of the role.
     *
     * @var string|null
     */
    public ?string $color = null;

    /**
     * The level of the role.
     *
     * @var int|null
     */
    public ?int $level = null;

    /**
     * The description of the role.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * The permissions of the role.
     *
     * @var array
     */
    public array $permissions = [];

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('roles')->ignore($this->role)
            ],
            'level' => [
                'required',
                'int',
                Rule::unique('roles')->ignore($this->role)
            ],
            'color' => 'required|min:7|max:7|hex_color',
            'description' => 'min:10',
            'permissions' => 'required'
        ];
    }

    /**
     * Function to store the model.
     *
     * @return Role
     */
    public function create(): Role
    {
        $properties = [
            'name',
            'color',
            'level',
            'description'
        ];

        $role = Role::create($this->only($properties));

        $role->syncPermissions($this->permissions);

        return $role;
    }

    /**
     * Function to update the model.
     *
     * @return Role
     */
    public function update(): Role
    {
        $this->role->update($this->only([
            'name',
            'color',
            'level',
            'description'
        ]));
        $this->role->syncPermissions($this->permissions);

        return $this->role->fresh();
    }
}
