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
        Schema::create('modems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('odp_id')
                ->nullable()
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('sn')->nullable();
            $table->string('ssid')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('port')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modems');
    }
};
