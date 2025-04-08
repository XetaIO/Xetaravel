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
    public ?string $last_name = null;

    /**
     * The first name of the user.
     *
     * @var string|null
     */
    public ?string $first_name = null;

    /**
     * The twitter of the user.
     *
     * @var string|null
     */
    public ?string $twitter = null;

    /**
     * The facebook of the user.
     *
     * @var string|null
     */
    public ?string $facebook = null;

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
     * The avatar of the user.
     *
     * @var TemporaryUploadedFile|null
     */
    #[Validate('image')]
    public $avatar;

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
                    'user_id' => $user->getKey(),
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

            //$this->avatar->store(path: 'photos');

            //dd(storage_path($this->avatar->store(path: 'private/livewire-tmp')));

            if (!is_null($this->avatar)) {
                //if ($file = storage_path($this->avatar->store(path: 'photos'))) {
                    $user->clearMediaCollection('avatar');
                    $user->addMediaFromDisk($this->avatar->getRealPath())
                        //->preservingOriginal()
                        ->setName(mb_substr(md5($user->username), 0, 10))
                        ->setFileName(mb_substr(md5($user->username), 0, 10))
                        ->toMediaCollection('avatar');
                //}
            }

            return $account;
        });
    }
}
