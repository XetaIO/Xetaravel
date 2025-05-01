<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Users
        $this->call(UsersTableSeeder::class);
        $this->call(AccountsTableSeeder::class);

        // Blog
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(BlogArticlesTableSeeder::class);
        $this->call(BlogCommentsTableSeeder::class);

        // Permissions
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);

        // Badges
        $this->call(BadgesTableSeeder::class);
        $this->call(BadgesUsersTableSeeder::class);

        // Discuss
        $this->call(DiscussCategoriesTableSeeder::class);
        $this->call(DiscussConversationsTableSeeder::class);
        $this->call(DiscussPostsTableSeeder::class);
        $this->call(DiscussUsersTableSeeder::class);
        $this->call(DiscussLogsTableSeeder::class);

        // Experiences & Rubies
        $this->call(ExperiencesTableSeeder::class);

        // Settings
        $this->call(SettingsTableSeeder::class);
    }
}
