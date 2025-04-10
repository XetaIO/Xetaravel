<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\AccountForm;
use Throwable;

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
        $this->form->load();
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
        $this->validate();

        $this->form->update();

        return redirect()
            ->route('user.account.index')
            ->success('Your account has been updated successfully !');
    }
}
