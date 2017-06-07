<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class CreateDiscussThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discuss_threads', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('content');
            $table->integer('comment_count')->unsigned()->default(0);
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_solved')->default(false);
            $table->boolean('is_edited')->default(false);
            $table->integer('solved_comment_id')->unsigned()->nullable()->index();
            $table->integer('last_comment_id')->unsigned()->nullable()->index();
            $table->integer('edited_user_id')->unsigned()->index();
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('discuss_threads', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('discuss_categories')->onDelete('cascade');
                $table->foreign('solved_comment_id')->references('id')->on('discuss_comments');
                $table->foreign('last_comment_id')->references('id')->on('discuss_comments');
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
        Schema::dropIfExists('discuss_threads');
    }
}
