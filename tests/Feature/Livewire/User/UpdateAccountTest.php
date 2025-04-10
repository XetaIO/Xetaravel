<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;
use Xetaravel\Livewire\User\UpdateAccount;
use Xetaravel\Models\User;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_page_contains_livewire_component()
    {
        $this->actingAs(User::find(1));

        $this->get(route('user.account.index'))
            ->assertSeeLivewire(UpdateAccount::class);
    }

    public function test_mount_component()
    {
        $user = User::find(1);

        Livewire::actingAs(User::find(1))
            ->test(UpdateAccount::class)
            ->assertSet('form.first_name', $user->first_name)
            ->assertSet('form.last_name', $user->last_name)
            ->assertSet('form.twitter', $user->twitter)
            ->assertSet('form.facebook', $user->facebook)
            ->assertSet('form.biography', $user->biography)
            ->assertSet('form.signature', $user->signature);
    }

    public function test_validates_fields_on_update()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Livewire::test(UpdateAccount::class)
            ->set('form.first_name', str_repeat('a', 51))
            ->call('update')
            ->assertHasErrors(['form.first_name' => 'max']);
    }

    public function test_updates_account_data_successfully()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Livewire::test(UpdateAccount::class)
            ->set('form.first_name', 'Jane')
            ->set('form.last_name', 'Smith')
            ->set('form.twitter', '@janesmith')
            ->set('form.facebook', 'jane.smith')
            ->set('form.biography', 'Updated bio')
            ->set('form.signature', 'Kind regards')
            ->call('update')
            ->assertRedirect(route('user.account.index'));

        $this->assertDatabaseHas('accounts', [
            'user_id' => $user->id,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
    }

    public function test_handles_avatar_upload()
    {
        Storage::fake('media');
        $user = User::find(1);
        $this->actingAs($user);

        $avatar = UploadedFile::fake()->image('avatar.jpg');

        Livewire::test(UpdateAccount::class)
            ->set('form.first_name', 'WithAvatar')
            ->set('form.avatar', $avatar)
            ->call('update')
            ->assertRedirect(route('user.account.index'));

        $user = $user->fresh();
        $this->assertNotNull($user->getFirstMedia('avatar'));
        $this->assertStringEndsWith('.jpg', $user->getFirstMedia('avatar')->file_name);
    }

    public function test_validates_avatar_must_be_an_image_and_max_10mb()
    {
        Storage::fake('media');
        $user = User::find(1);
        $this->actingAs($user);

        $nonImage = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $tooLarge = UploadedFile::fake()->image('big-image.jpg')->size(11000); // 11MB

        // Test non-image file
        Livewire::test(UpdateAccount::class)
            ->set('form.avatar', $nonImage)
            ->call('update')
            ->assertHasErrors(['form.avatar' => 'image']);

        // Test too large image
        Livewire::test(UpdateAccount::class)
            ->set('form.avatar', $tooLarge)
            ->call('update')
            ->assertHasErrors(['form.avatar' => 'max']);
    }
}
