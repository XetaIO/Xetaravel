<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_item_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('shop_item_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('shop_item_user', function (Blueprint $table) {
                $table->foreign('shop_item_id')->references('id')->on('shop_items')->onDelete('cascade');
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
        Schema::dropIfExists('shop_item_user');
    }
};
