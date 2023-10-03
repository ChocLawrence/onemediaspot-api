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
        Schema::dropIfExists('status_histories');
        Schema::create('status_histories', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('note');
             $table->foreignId('status_id')
             ->constrained('statuses')
             ->onDelete('cascade');
             $table->foreignId('advert_id')
             ->nullable()
             ->constrained('adverts')
             ->onDelete('cascade');
             $table->foreignId('service_id')
             ->nullable()
             ->constrained('services')
             ->onDelete('cascade');
             $table->foreignId('institution_id')
             ->nullable()
             ->constrained('institutions')
             ->onDelete('cascade');
             $table->foreignId('institution_access_id')
             ->nullable()
             ->constrained('institution_accesses')
             ->onDelete('cascade');
             $table->foreignId('user_id')
             ->nullable()
             ->constrained('users')
             ->onDelete('cascade');
             $table->string('suspension_days')->nullable();
             $table->string('suspension_exp')->nullable();
             $table->string('user_marked_date')->nullable(); 
             $table->string('user_marked_exp_date')->nullable();
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
        Schema::dropIfExists('status_histories');
        Schema::enableForeignKeyConstraints();
    }
};
