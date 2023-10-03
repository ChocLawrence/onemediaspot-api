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
        Schema::dropIfExists('towns');
        Schema::create('towns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('abbr')->nullable();
            $table->foreignId('city_id')
            ->nullable()
            ->constrained('cities')
            ->onDelete('cascade');  
            $table->foreignId('region_id')
            ->nullable()
            ->constrained('regions')
            ->onDelete('cascade');  
            $table->foreignId('country_id')
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
        Schema::dropIfExists('towns');
        Schema::enableForeignKeyConstraints();
    }
};
