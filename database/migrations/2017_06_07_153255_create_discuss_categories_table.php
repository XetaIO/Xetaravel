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
        Schema::create('discuss_categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->string('color', 7)->default('#e7edf3');
            $table->string('icon')->nullable();
            $table->integer('level');
            $table->integer('conversation_count')->unsigned()->default(0);
            $table->integer('last_conversation_id')->unsigned()->nullable()->index();
            $table->boolean('is_locked')->default(false);
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
        Schema::dropIfExists('discuss_categories');
    }
};
