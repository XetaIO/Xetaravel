<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('article_id')->unsigned()->index();
            $table->longText('content');
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() == 'testing') {
            Schema::table('comments', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('article_id')->references('id')->on('articles');
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
        Schema::dropIfExists('comments');
    }
}