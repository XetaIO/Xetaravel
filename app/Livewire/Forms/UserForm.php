<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\Account;
use Xetaravel\Models\User;
use Throwable;

class UserForm extends Form
{
    /**
     * The category to update.
     *
     * @var User|null
     */
    public ?User $user = null;

    /**
     * The username of the user.
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     * The email of the user.
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     * The first_name of the user.
     *
     * @var string|null
     */
    public ?string $first_name = null;

    /**
     * The last_name of the user.
     *
     * @var string|null
     */
    public ?string $last_name = null;

    /**
     * The facebook of the user.
     *
     * @var string|null
     */
    public ?string $facebook = null;

    /**
     * The twitter of the user.
     *
     * @var string|null
     */
    public ?string $twitter = null;

    /**
     * The biography of the user.
     *
     * @var string|null
     */
    public ?string $biography = null;

    /**
     * The signature of the user.
     *
     * @var string|null
     */
    public ?string $signature = null;

    /**
     * The roles of the user.
     *
     * @var array
     */
    public array $roles = [];

    /**
     * The permissions of the user.
     *
     * @var array
     */
    public array $permissions = [];

    /**
     * Whatever the user have the by_pass permission.
     *
     * @var bool|null
     */
    public ?bool $can_bypass = null;

    protected function rules(): array
    {
        return [
            'username' => [
                'required',
                'alpha_num',
                'min:4',
                'max:20',
                Rule::unique('users')->ignore($this->user)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user)
            ],
            'first_name' => 'max:20',
            'last_name' => 'max:20',
            'facebook' => 'max:50',
            'twitter' => 'max:50'
        ];
    }

    /**
     * Function to update the model.
     *
     * @return User
     *
     * @throws Throwable
     */
    public function update(): User
    {
        return DB::transaction(function () {
            // Update the user
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            $this->user->save();

            // Create or Update the account
            $account = Account::updateOrCreate(
                [
                    'user_id' => $this->user->getKey(),
                ],
                [
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'facebook' => $this->facebook,
                    'twitter' => $this->twitter,
                    'biography' => $this->biography,
                    'signature' => $this->signature,
                ]
            );

            $parser = new MentionParser($account, [
                'regex' => config('mentions.regex'),
                'mention' => false
            ]);
            $signature = $parser->parse($account->signature);
            $biography = $parser->parse($account->biography);

            $account->signature = $signature;
            $account->biography = $biography;
            $account->save();

            $this->user->syncRoles($this->roles);

            // Link the selected permissions to the user.
            if (auth()->user()->can('assignDirectPermission', $this->user)) {
                $this->user->syncPermissions($this->permissions);

                if ($this->can_bypass) {
                    $this->user->givePermissionTo('bypass login');
                } else {
                    $this->user->revokePermissionTo('bypass login');
                }
            }

            return $this->user;
        });
    }
}
