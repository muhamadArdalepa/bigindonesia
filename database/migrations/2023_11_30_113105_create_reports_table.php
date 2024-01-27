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
        Schema::create('reports', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('cs_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('noc_id')->nullable()->constrained('users')->nullOnDelete()->onUpdate('cascade');
            $table->enum('report_type',['Gangguan', 'Ganti Password', 'Pemutusan', 'Pindah Alamat', 'Lainnya']);
            $table->enum('disrupt_type',['Tidak Konek', 'Redaman Tinggi', 'LOS','Lainnya'])->nullable();
            $table->string('pictures')->nullable();
            $table->string('desc')->nullable();
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
