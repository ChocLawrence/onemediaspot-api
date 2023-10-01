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
        Schema::dropIfExists('followers');
        Schema::create('followers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('service_id')
             ->constrained('services')
             ->onDelete('cascade');
            $table->foreignId('user_id')
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
        Schema::dropIfExists('followers');
        Schema::enableForeignKeyConstraints();
    }
};
