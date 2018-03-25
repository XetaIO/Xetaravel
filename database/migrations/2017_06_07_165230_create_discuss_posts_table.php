<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class CreateDiscussPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discuss_posts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('conversation_id')->unsigned()->index();
            $table->longText('content');
            $table->boolean('is_solved')->default(false);
            $table->integer('edit_count')->unsigned()->default(0);
            $table->boolean('is_edited')->default(false);
            $table->integer('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('discuss_categories', function (Blueprint $table) {
                $table->foreign('last_conversation_id')->references('id')->on('discuss_conversations');
            });

            Schema::table('discuss_conversations', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('discuss_categories')->onDelete('cascade');
                $table->foreign('first_post_id')->references('id')->on('discuss_posts');
                $table->foreign('solved_post_id')->references('id')->on('discuss_posts');
                $table->foreign('last_post_id')->references('id')->on('discuss_posts');
                $table->foreign('edited_user_id')->references('id')->on('users');
            });

            Schema::table('discuss_posts', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('conversation_id')->references('id')->on('discuss_conversations')->onDelete('cascade');
                $table->foreign('edited_user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discuss_posts');
    }
}
