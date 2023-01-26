<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->integer('shop_item_count')->unsigned()->default(0);
            $table->boolean('is_display')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_categories');
    }
};