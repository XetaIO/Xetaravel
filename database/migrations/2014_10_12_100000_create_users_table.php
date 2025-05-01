<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('username', 20)->unique()->index();
            $table->string('email', 50)->unique()->index();
            $table->string('password')->nullable();
            $table->string('slug', 20)->unique();
            $table->string('github_id')->nullable()->unique();
            $table->integer('blog_comment_count')->unsigned()->default(0);
            $table->integer('blog_article_count')->unsigned()->default(0);
            $table->integer('discuss_conversation_count')->unsigned()->default(0);
            $table->integer('discuss_post_count')->unsigned()->default(0);
            $table->integer('experiences_total')->unsigned()->default(0);
            $table->integer('rubies_total')->unsigned()->default(0);
            $table->rememberToken();
            $table->ipAddress('register_ip');
            $table->ipAddress('last_login_ip')->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('deleted_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
