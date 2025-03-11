<?php

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
        $this->call(UsersTableSeed::class);
        $this->call(AccountsTableSeed::class);

        // Blog
        $this->call(BlogCategoriesTableSeed::class);
        $this->call(BlogArticlesTableSeed::class);
        $this->call(BlogCommentsTableSeed::class);

        // Permissions
        $this->call(RolesTableSeed::class);
        $this->call(PermissionsTableSeed::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);

        // Badges
        $this->call(BadgesTableSeed::class);
        $this->call(BadgesUsersTableSeed::class);

        // Discuss
        $this->call(DiscussCategoriesTableSeed::class);
        $this->call(DiscussConversationsTableSeed::class);
        $this->call(DiscussPostsTableSeed::class);
        $this->call(DiscussUsersTableSeed::class);
        $this->call(DiscussLogsTableSeed::class);

        // Experiences & Rubies
        $this->call(ExperiencesTableSeed::class);

        // Settings
        $this->call(SettingsTableSeed::class);
    }
}
