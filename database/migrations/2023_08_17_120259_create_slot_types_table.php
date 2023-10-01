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
        Schema::dropIfExists('slot_types');
        Schema::create('slot_types', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string('name');
             $table->string('description')->nullable();
             $table->string('cost')->nullable();
             $table->string('days')->nullable();
             $table->string('audience')->nullable();
             $table->boolean('negotiable')->default(false);
             $table->decimal('longitude', 10, 8)->nullable();
             $table->decimal('latitude', 11, 8)->nullable();
             $table->foreignId('service_id')
             ->constrained('services')
             ->onDelete('cascade'); 
             $table->foreignId('created_by')
             ->constrained('users')
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
        Schema::dropIfExists('slot_types');
        Schema::enableForeignKeyConstraints();
    }
};
