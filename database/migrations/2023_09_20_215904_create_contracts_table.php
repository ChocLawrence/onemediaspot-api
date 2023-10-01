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
        Schema::dropIfExists('contracts');
        Schema::create('contracts', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->foreignId('asset_type_id')
             ->nullable()
             ->constrained('assets')
             ->onDelete('cascade');  
             $table->mediumText('asset')->nullable();
             $table->foreignId('status_id')
             ->constrained('statuses')
             ->onDelete('cascade');
             $table->foreignId('institution_id')
             ->nullable()
             ->constrained('institutions')
             ->onDelete('cascade');
             $table->foreignId('ext_institution_id')
             ->nullable()
             ->constrained('institutions')
             ->onDelete('cascade');
             $table->foreignId('user_id')
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
        Schema::dropIfExists('contracts');
        Schema::enableForeignKeyConstraints();
    }
};
