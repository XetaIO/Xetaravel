<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        // General Settings
        Setting::create([
            'key' => 'app_login_enabled',
            'value' => true,
            'label' => 'Activation of the connection system.',
            'text' => 'Enable/Disable the login system.',
            'label_info' => 'Check to enable the site login system. <br><b>When the login system is disabled, only people with the direct <code class="text-neutral-content bg-neutral rounded-sm py-0.5 px-2">bypass login</code> permission will be able to log in.</b>'
        ]);
        Setting::create([
            'key' => 'app_register_enabled',
            'value' => true,
            'label' => 'Activation of the register system.',
            'text' => 'Enable/Disable the register system.'
        ]);
        Setting::create([
            'key' => 'user_email_verification_enabled',
            'value' => true,
            'label' => 'Activation of the email verification system.',
            'text' => 'Enable/Disable the email verification system.'
        ]);

        // Blog
        Setting::create([
            'key' => 'blog_enabled',
            'value' => true,
            'label' => 'Activation of the Blog system.',
            'text' => 'Enable/Disable the Blog system.'
        ]);

        // Discuss
        Setting::create([
            'key' => 'discuss_enabled',
            'value' => true,
            'label' => 'Activation of the Discuss system.',
            'text' => 'Enable/Disable the Discuss system.'
        ]);

        // Contact
        Setting::create([
            'key' => 'contact_enabled',
            'value' => true,
            'label' => 'Activation of the contact page.',
            'text' => 'Enable/Disable the contact page.'
        ]);

        // User
        Setting::create([
            'key' => 'user_manage_enabled',
            'value' => true,
            'label' => 'Activation of the user management system.',
            'text' => 'Enable/Disable the user management system.'
        ]);

        // Role
        Setting::create([
            'key' => 'role_manage_enabled',
            'value' => true,
            'label' => 'Activation of the role management system.',
            'text' => 'Enable/Disable the role management system.'
        ]);

        // Permission
        Setting::create([
            'key' => 'permission_manage_enabled',
            'value' => true,
            'label' => 'Activation of the permission management system.',
            'text' => 'Enable/Disable the permission management system.'
        ]);

        // Google Analytics
        Setting::create([
            'key' => 'analytics_enabled',
            'value' => true,
            'label' => 'Activation of the Google Analytics system.',
            'text' => 'Enable/Disable the Google Analytics  system.'
        ]);

    }
}
