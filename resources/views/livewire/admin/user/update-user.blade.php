<div>
    <x-modal wire:model="showModal" title="Update a User" class="backdrop-blur" box-class="w-11/12 max-w-5xl">
        @if ($form->user?->trashed())
            <div>
                <x-alert type="error" class="mb-4" title="Attention">
                    <span class="block font-bold">
                        This user has been deleted at {{ $form->user->deleted_at->translatedFormat( 'D j M Y à H:i') }} by {{ $form->user->deletedUser->full_name }}.
                    </span>
                    You need to restore the user before doing any modification.
                </x-alert>
            </div>
        @endif

        <x-form.input wire:model="form.username" name="form.username" label="Username" />

        <x-form.input wire:model="form.email" name="form.email" label="Email" type="email" />

        <x-form.input wire:model="form.first_name" name="form.first_name" label="First Name" />

        <x-form.input wire:model="form.last_name" name="form.last_name" label="Last Name" />

        <x-form.input wire:model="form.twitter" name="form.twitter" label="Twitter" />

        <x-form.input wire:model="form.facebook" name="form.facebook" label="Facebook" />

        <x-form.select
            class="min-h-[100px]"
            :options="$roles"
            wire:model="form.roles"
            name="form.roles"
            label="Roles"
            option-label="name"
            option-value="name"
            multiple
        />

        <x-form.checkbox wire:model="form.can_bypass" name="form.can_bypass" label="Bypass permission" text="Check to enable the bypass permission" />

        @can('assignDirectPermission', \Xetaravel\Models\User::class)
            <x-alert type="info">
                Tips: Always favor roles over direct permissions whenever possible.
            </x-alert>

            <x-form.select
                class="min-h-[250px]"
                :options="$permissions"
                wire:model="form.permissions"
                name="form.permissions"
                label="Direct Permissions"
                option-label="name"
                option-value="name"
                multiple
            />
        @endcan

        @php
            $config = [
                'sideBySideFullscreen' => false,
                'maxHeight' => '200px'
            ];
        @endphp
        <x-form.markdown :config="$config" wire:model="form.biography" name="form.biography" label="Biography" />

        <x-form.markdown :config="$config" wire:model="form.signature" name="form.signature" label="Signature" />

        <x-slot:actions>
            <x-button class="btn-warning tooltip" label="Delete avatar" icon="fas-rotate" type="button" wire:click="deleteAvatar({{ $form->user?->getKey() }})"  data-tip="Delete the avatar of the user" spinner />
            @if($form->user?->trashed())
                <x-button class="btn-accent tooltip" label="Restore" icon="fas-unlock" type="button" wire:click="restore" data-tip="Restore the user" spinner />
            @else
                <x-button class="btn-success tooltip" label="Update" icon="fas-pencil" type="button" wire:click="update" data-tip="Update the user" spinner />
            @endif
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // User Update Button
            const userUpdateButton = document.getElementsByClassName('userUpdateButton');
            Array.from(userUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-user', { id: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>
