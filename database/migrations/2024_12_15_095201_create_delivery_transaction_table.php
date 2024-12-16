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
        Schema::create('delivery_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menambahkan tanda kurung
            $table->string('nomor_resi')->unique(); // Sesuaikan dengan string
            $table->date('tanggal_resi');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_transaction');
    }
};
