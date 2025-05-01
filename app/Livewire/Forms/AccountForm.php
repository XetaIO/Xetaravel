<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\Account;
use Throwable;
use Xetaravel\Models\User;

class AccountForm extends Form
{
    /**
     * The last name of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $last_name = null;

    /**
     * The first name of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $first_name = null;

    /**
     * The twitter of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $twitter = null;

    /**
     * The facebook of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $facebook = null;

    /**
     * The biography of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $biography = null;

    /**
     * The signature of the user.
     *
     * @var string|null
     */
    #[Validate('max:50')]
    public ?string $signature = null;

    /**
     * The avatar of the user.
     *
     * @var TemporaryUploadedFile|null
     */
    #[Validate('nullable|image|max:10240')]
    public ?TemporaryUploadedFile $avatar = null;

    /**
     * Load the fields.
     *
     * @return void
     */
    public function load(): void
    {
        $user = Auth::user();

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->twitter = $user->twitter;
        $this->facebook = $user->facebook;
        $this->biography = $user->biography;
        $this->signature = $user->signature;
    }

    /**
     * Function to create the post.
     *
     * @return Account
     *
     * @throws Throwable
     */
    public function update(): Account
    {
        return DB::transaction(function () {
            $user = User::find(Auth::id());

            $account = Account::updateOrCreate(
                [
                    'user_id' => $user->getKey(),
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

            if (!is_null($this->avatar)) {
                $user->clearMediaCollection('avatar');
                $user->addMedia($this->avatar->getRealPath())
                    ->setName(mb_substr(md5($user->username), 0, 10))
                    ->setFileName(mb_substr(md5($user->username), 0, 10) . '.' . $this->avatar->getClientOriginalExtension())
                    ->toMediaCollection('avatar');
            }

            return $account;
        });
    }
}
