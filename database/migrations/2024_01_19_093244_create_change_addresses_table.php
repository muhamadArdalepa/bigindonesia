<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('change_addresses', function (Blueprint $table) {
            $table->string('report_id');
            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->string('address');
            $table->string('coordinate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_addresses');
    }
};
