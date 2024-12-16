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
        Schema::create('delivery_logs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menambahkan tanda kurung
            $table->string('nomor_resi'); // Gunakan string sesuai dengan tipe data di tabel utama
            $table->date('tanggal');
            $table->string('kota');
            $table->text('keterangan');
    
            // Foreign key yang menghubungkan dengan delivery_transaction
            $table->foreign('nomor_resi')->references('nomor_resi')->on('delivery_transactions')->onDelete('cascade');
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_log');
    }
};
