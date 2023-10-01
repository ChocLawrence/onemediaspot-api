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
        Schema::dropIfExists('sizes');
        Schema::create('sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->foreignId('unit_id')
            ->nullable()
            ->constrained('units')
            ->onDelete('cascade');
            $table->foreignId('slot_type_id')
             ->nullable()
             ->constrained('slot_types')
             ->onDelete('cascade');
             $table->foreignId('created_by')
             ->nullable()
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
        Schema::dropIfExists('sizes');
        Schema::enableForeignKeyConstraints();
    }
};
