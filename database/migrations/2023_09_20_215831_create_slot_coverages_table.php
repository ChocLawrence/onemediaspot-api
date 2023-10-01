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
        Schema::dropIfExists('slot_coverages');
        Schema::create('slot_coverages', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('advert_count')->default(1);
             $table->foreignId('plan_id')
             ->constrained('plans')
             ->onDelete('cascade');
             $table->foreignId('slot_id')
             ->nullable()
             ->constrained('slots')
             ->onDelete('cascade');
             $table->foreignId('institution_id')
             ->constrained('institutions')
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
        Schema::dropIfExists('slot_coverages');
        Schema::enableForeignKeyConstraints();
    }
};
