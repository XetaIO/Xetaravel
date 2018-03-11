<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class CreateBadgeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('badge_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('badge_user', function (Blueprint $table) {
                $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('badge_user');
    }
}
