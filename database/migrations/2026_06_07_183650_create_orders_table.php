<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order')->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggan');
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['antri', 'proses', 'selesai', 'diambil'])->default('antri');
            $table->enum('status_bayar', ['belum', 'lunas'])->default('belum');
            $table->date('tgl_masuk');
            $table->date('estimasi_selesai');
            $table->date('tgl_diambil')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('metode_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
