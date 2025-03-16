<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('blog_category_id')->unsigned()->index();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('content');
            $table->integer('blog_comment_count')->unsigned()->default(0);
            $table->boolean('is_display')->default(true);
            $table->timestamps();
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_articles');
    }
};
