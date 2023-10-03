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
        Schema::dropIfExists('cities');
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('abbr')->nullable();
            $table->foreignId('region_id')
            ->nullable()
            ->constrained('regions')
            ->onDelete('cascade');  
            $table->foreignId('country_id')
            ->nullable()
            ->constrained('countries')
            ->onDelete('cascade');  
            $table->rememberToken();
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
        Schema::dropIfExists('cities');
        Schema::enableForeignKeyConstraints();
    }
};
