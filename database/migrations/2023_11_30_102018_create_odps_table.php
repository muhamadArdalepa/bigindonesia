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
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('odc_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('coordinate');
            $table->tinyInteger('splitter');
            $table->string('address');
            $table->string('desc')->nullable();
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
        Schema::dropIfExists('odps');
    }
};
