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
        Schema::dropIfExists('adverts');
        Schema::create('adverts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('slot_id')
            ->constrained('slots')
            ->onDelete('cascade');  
            $table->mediumText('text')->nullable();
            $table->longText('files')->nullable();
            $table->mediumText('files_url')->nullable();
            $table->string('total_repeat_count')->default(1);
            $table->foreignId('status_id')
            ->constrained('statuses')
            ->onDelete('cascade');
            $table->foreignId('user_id')
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
        Schema::dropIfExists('adverts');
        Schema::enableForeignKeyConstraints();
    }
};
