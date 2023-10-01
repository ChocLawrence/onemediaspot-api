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
        Schema::dropIfExists('valid_asset_types');
        Schema::create('valid_asset_types', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->foreignId('asset_type_id')
             ->constrained('asset_types')
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
        Schema::dropIfExists('valid_asset_types');
        Schema::enableForeignKeyConstraints();
    }
};

