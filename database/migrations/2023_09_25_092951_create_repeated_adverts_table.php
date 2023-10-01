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
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('repeated_adverts');
        Schema::create('repeated_adverts', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->foreignId('advert_id')
             ->constrained('adverts')
             ->onDelete('cascade');
             $table->string('date');
             $table->string('current_repeat_count');
             $table->string('current_repeat_end_date');
             $table->foreignId('status_id')
             ->constrained('statuses')
             ->onDelete('cascade');
             $table->timestamps();
         });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('repeated_adverts');
        Schema::enableForeignKeyConstraints();
    }
};
