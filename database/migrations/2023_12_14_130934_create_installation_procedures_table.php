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
        Schema::create('installation_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('pictures')->nullable();
            $table->string('coordinate')->nullable();
            $table->string('address')->nullable();
            $table->string('desc')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('installation_procedures');
    }
};
