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
        Schema::dropIfExists('occurences');
        Schema::create('occurences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('day_id')
            ->nullable()
            ->constrained('days')
            ->onDelete('cascade');
            $table->foreignId('frequency_id')
            ->constrained('frequencies')
            ->onDelete('cascade');
            $table->foreignId('slot_type_id')
            ->constrained('slot_types')
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
        Schema::dropIfExists('occurences');
        Schema::enableForeignKeyConstraints();
    }
};
