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
        Schema::dropIfExists('institutions');
        Schema::create('institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->mediumText('image')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('country_id')
            ->nullable()
            ->constrained('countries')
            ->onDelete('cascade');  
            $table->string('email')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->unique();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->foreignId('institution_type_id')
            ->nullable()
            ->constrained('institution_types')
            ->onDelete('cascade');  
            $table->foreignId('status_id')
                 ->default(1)
                 ->nullable()
                 ->constrained('statuses')
                 ->onDelete('cascade');
            $table->foreignId('created_by')
                 ->constrained('users')
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
        Schema::dropIfExists('institutions');
        Schema::enableForeignKeyConstraints();
    }
};
