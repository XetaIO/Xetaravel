<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // Pivot badge_user: Prevent duplicate
        Schema::table('badge_user', function (Blueprint $table) {
            $table->unique(['badge_id', 'user_id'], 'badge_user_unique');
        });

        // Users.deleted_user_id: Set NULL on DELETE
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['deleted_user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('deleted_user_id')->references('id')->on('users')->nullOnDelete();
        });

        // Users.email & Users.slug: Change length
        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 255)->change();
            $table->string('slug', 50)->change();
        });

        // Delete useless indexes
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropIndex('blog_categories_slug_index');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->dropIndex('blog_articles_slug_index');
        });

        Schema::table('discuss_categories', function (Blueprint $table) {
            $table->dropIndex('discuss_categories_slug_index');
        });

        Schema::table('discuss_conversations', function (Blueprint $table) {
            $table->dropIndex('discuss_conversations_slug_index');
        });
    }

    public function down(): void
    {
        Schema::table('badge_user', function (Blueprint $table) {
            $table->dropUnique('badge_user_unique');
        });

        Schema::table('discuss_conversations', function (Blueprint $table) {
            $table->dropFullText('discuss_conversations_title_fulltext');
        });

        Schema::table('discuss_posts', function (Blueprint $table) {
            $table->dropFullText('discuss_posts_content_fulltext');
        });

    }
};
