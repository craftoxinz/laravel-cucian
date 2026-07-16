<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tipe order: datang langsung ke toko, atau minta dijemput kurir
            $table->enum('tipe_order', ['datang_langsung', 'delivery'])
                ->default('datang_langsung')
                ->after('user_id');

            // Alamat penjemputan, hanya diisi kalau tipe_order = delivery
            $table->text('alamat_jemput')->nullable()->after('tipe_order');

            // Kurir yang mengambil order (diisi belakangan saat kurir approve/ambil order)
            $table->foreignId('kurir_id')->nullable()->after('alamat_jemput')
                ->constrained('users')->nullOnDelete();

            // Status penjemputan oleh kurir, hanya relevan untuk order delivery
            $table->enum('status_jemput', [
                'menunggu',
                'menuju_lokasi',
                'menuju_laundry',
                'selesai_diantar',
                'mengantar_ke_pelanggan',
                'selesai'
            ])->nullable()->after('kurir_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['kurir_id']);
            $table->dropColumn(['tipe_order', 'alamat_jemput', 'kurir_id', 'status_jemput']);
        });
    }
};
