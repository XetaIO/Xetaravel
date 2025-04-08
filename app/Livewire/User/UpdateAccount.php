<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\AccountForm;
use Throwable;
use Xetaravel\Models\User;

class UpdateAccount extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithFileUploads;

    /**
     * The form used to create/update a model.
     *
     * @var AccountForm
     */
    public AccountForm $form;

    public function mount(): void
    {
        $user = User::with('account')->find(Auth::user()->id);
        $this->form->first_name = $user->first_name;
        $this->form->last_name = $user->last_name;
        $this->form->twitter = $user->twitter;
        $this->form->facebook = $user->facebook;
        $this->form->biography = $user->biography;
        $this->form->signature = $user->signature;
    }

    public function render()
    {
        return view('livewire.user.update-account');
    }

    /**
     * Update the post.
     *
     * @throws Throwable
     */
    public function update()
    {
        $this->validate([
            'form.first_name' => 'max:50',
            'form.last_name' => 'max:50',
            'form.facebook' => 'max:50',
            'form.twitter' => 'max:50'
        ]);

        $this->form->update();

        return redirect()
            ->route('user.account.index')
            ->success('Your account has been updated successfully !');
    }
}
