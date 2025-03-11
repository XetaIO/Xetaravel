<?php

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
        Schema::create('mentions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('model_type');
            $table->integer('model_id')->unsigned();
            $table->string('recipient_type');
            $table->integer('recipient_id')->unsigned();
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
        Schema::dropIfExists('mentions');
    }
};
