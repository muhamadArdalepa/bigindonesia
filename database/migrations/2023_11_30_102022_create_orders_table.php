<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('customer_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('marketer_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('verifier_id')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('noc_id')->nullable()->constrained('users')->nullOnDelete()->onUpdate('cascade');
            $table->foreignId('cs_id')->nullable()->constrained('users')->nullOnDelete()->onUpdate('cascade');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('orders');
    }
};
