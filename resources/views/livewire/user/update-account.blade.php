<div>
    <section class="rounded-lg bg-base-100 dark:bg-base-300 shadow-md py-4 px-8 mb-10">
        <h2 class="divider text-2xl mb-6">
            My Account
        </h2>

        <div class="grid grid-cols-12 gap-4 mb-7">
            <div class="col-span-12 lg:col-span-6">
                <x-file wire:model="form.avatar" label="Avatar" accept="image/png, image/jpeg">
                    <img src="{{ Auth::user()->avatar_medium }}" class="h-40 rounded-lg ring-2 ring-base-content ring-offset-base-100 ring-offset-2"  alt="{{ Auth::user()->username }} avatar" />
                </x-file>
            </div>
            <div class="col-span-12 lg:col-span-6">
                <x-input wire:model="form.first_name" name="form.first_name" label="First Name" placeholder="Your First Name..." />
                <x-input wire:model="form.last_name" name="form.last_name" label="Last Name" placeholder="Your Last Name..." />
            </div>
        </div>

        <x-input label="Facebook" wire:model="form.facebook" prefix="https://facebook.com/" placeholder="Your Facebook here..." />

        <x-input label="Twitter" wire:model="form.twitter" prefix="https://twitter.com/" placeholder="Your Facebook here..." />

        @php
            $config = [
                'sideBySideFullscreen' => false
            ];
        @endphp
        <x-markdown :config="$config" wire:model="form.biography" name="form.biography" label="Biography" placeholder="Your biography here..." />

        <x-markdown :config="$config" wire:model="form.signature" name="form.signature" label="Signature" placeholder="Your signature here..." />

        <div class="text-center">
            <x-button class="btn-primary gap-2" label="Save" icon="far-floppy-disk" type="button" wire:click="update" spinner />
        </div>
    </section>
</div>
