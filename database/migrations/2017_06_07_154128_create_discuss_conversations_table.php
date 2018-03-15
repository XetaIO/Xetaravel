<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDiscussConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discuss_conversations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->string('title');
            $table->string('slug');
            $table->integer('post_count')->unsigned()->default(0);
            $table->integer('user_count')->unsigned()->default(0);
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_solved')->default(false);
            $table->boolean('is_edited')->default(false);
            $table->integer('first_post_id')->unsigned()->nullable()->index();
            $table->integer('solved_post_id')->unsigned()->nullable()->index();
            $table->integer('last_post_id')->unsigned()->nullable()->index();
            $table->integer('edit_count')->unsigned()->default(0);
            $table->integer('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamp('edited_at')->nullable();
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
        Schema::dropIfExists('discuss_conversations');
    }
}
