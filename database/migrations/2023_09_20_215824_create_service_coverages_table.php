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
        Schema::dropIfExists('service_coverages');
        Schema::create('service_coverages', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('advert_count')->default(1);
             $table->foreignId('plan_id')
             ->constrained('plans')
             ->onDelete('cascade');
             $table->foreignId('service_id')
             ->nullable()
             ->constrained('services')
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
        Schema::dropIfExists('service_coverages');
        Schema::enableForeignKeyConstraints();
    }
};
