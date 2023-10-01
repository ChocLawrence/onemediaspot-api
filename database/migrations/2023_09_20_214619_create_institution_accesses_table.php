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
        Schema::dropIfExists('institution_accesses');
        Schema::create('institution_accesses', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('job_title');
             $table->string('email')->unique()->nullable();
             $table->string('phone')->unique()->nullable();
             $table->foreignId('status_id')
             ->constrained('statuses')
             ->onDelete('cascade');
             $table->foreignId('user_id')
             ->constrained('users')
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
        Schema::dropIfExists('institution_accesses');
        Schema::enableForeignKeyConstraints();
    }
};
