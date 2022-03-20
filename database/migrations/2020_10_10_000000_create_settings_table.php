<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique()->index();
            $table->unsignedInteger('value_int')->nullable();
            $table->text('value_str')->nullable();
            $table->boolean('value_bool')->nullable();
            $table->string('description')->nullable();
            $table->integer('last_updated_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        /**
         * Only create foreign key on production/development.
         */
        if (App::environment() !== 'testing') {
            Schema::table('settings', function (Blueprint $table) {
                $table->foreign('last_updated_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('settings');
    }
}
