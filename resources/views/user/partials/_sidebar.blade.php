<ul class="flex flex-col w-full border border-gray-200 rounded-lg dark:bg-base-300 dark:border-gray-700">
    <li>
        <a @class([
            'block border-l-4 gap-2 px-4 py-3 hover:border-primary rounded-t-lg',
            'border-primary' => request()->route()->getName() === 'user.account.index',
            'border-transparent' => request()->route()->getName() !== 'user.account.index'])
           href="{{ route('user.account.index') }}">
            <x-icon name="fas-user-pen" />
            Account
        </a>
    </li>
    <li>
        <a @class([
            'block border-l-4 gap-2 px-4 py-3 hover:border-primary',
            'border-primary' => request()->route()->getName() === 'user.notification.index',
            'border-transparent' => request()->route()->getName() !== 'user.notification.index'])
           href="{{ route('user.notification.index') }}">
            <x-icon name="fas-user-tag" />
            Notifications
        </a>
    </li>
    <li>
        <a @class([
            'block border-l-4 gap-2 px-4 py-3 hover:border-primary',
            'border-primary' => request()->route()->getName() === 'user.setting.index',
            'border-transparent' => request()->route()->getName() !== 'user.setting.index'])
           href="{{ route('user.setting.index') }}">
            <x-icon name="fas-user-gear" />
            Settings
        </a>
    </li>
    <li>
        <a @class([
            'block border-l-4 gap-2 px-4 py-3 hover:border-primary rounded-b-lg',
            'border-primary' => request()->route()->getName() === 'user.security.index',
            'border-transparent' => request()->route()->getName() !== 'user.security.index'])
           href="{{ route('user.security.index') }}">
            <x-icon name="fas-user-shield" />
            Security
        </a>
    </li>
</ul>
