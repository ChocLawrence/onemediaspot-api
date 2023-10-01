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
        Schema::dropIfExists('user_roles');
        Schema::create('user_roles', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->foreignId('user_id')
             ->constrained('users')
             ->onDelete('cascade');
             $table->foreignId('role_id')
             ->constrained('roles')
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
        Schema::dropIfExists('user_roles');
        Schema::enableForeignKeyConstraints();
    }
};
