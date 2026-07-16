<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add 'dibatalkan' to the ENUM of orders.status
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('antri','proses','selesai','diambil','dibatalkan') NOT NULL DEFAULT 'antri'");
    }

    public function down(): void
    {
        // Revert to previous enum (without 'dibatalkan')
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('antri','proses','selesai','diambil') NOT NULL DEFAULT 'antri'");
    }
};
