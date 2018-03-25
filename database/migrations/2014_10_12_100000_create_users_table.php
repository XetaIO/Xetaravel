<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('username', 20)->unique()->index();
            $table->string('email', 50)->unique()->index();
            $table->string('password')->nullable();
            $table->string('slug', 20)->unique();
            $table->string('github_id')->nullable()->unique();
            $table->integer('comment_count')->unsigned()->default(0);
            $table->integer('article_count')->unsigned()->default(0);
            $table->integer('discuss_conversation_count')->default(0);
            $table->integer('discuss_post_count')->default(0);
            $table->integer('experiences_total')->default(0);
            $table->integer('rubies_total')->default(0);
            $table->rememberToken();
            $table->ipAddress('register_ip');
            $table->ipAddress('last_login_ip')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
