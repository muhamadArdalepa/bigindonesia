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
        Schema::create('absen_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absen_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->tinyInteger('index');
            $table->string('picture')->nullable();
            $table->string('coordinate');
            $table->string('address');
            $table->string('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_details');
    }
};
