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
        Schema::create('reparation_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reparation_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('pictures');
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
        Schema::dropIfExists('reparation_procedures');
    }
};
