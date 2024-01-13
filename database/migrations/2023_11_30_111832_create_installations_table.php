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
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->foreignId('noc_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->onUpdate('cascade');
            $table->foreignId('cs_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->onUpdate('cascade');
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->onUpdate('cascade');
            $table->enum('cable_type',['dw','precon']);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('installations');
    }
};
