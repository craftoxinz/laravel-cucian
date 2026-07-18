<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            if (!Schema::hasColumn('pelanggan', 'email')) {
                $table->string('email')->nullable()->unique()->after('alamat');
            }
            if (!Schema::hasColumn('pelanggan', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
            if (!Schema::hasColumn('pelanggan', 'remember_token')) {
                $table->rememberToken()->nullable()->after('password');
            }
            if (!Schema::hasColumn('pelanggan', 'is_member')) {
                $table->boolean('is_member')->default(false)->after('remember_token');
            }
            if (!Schema::hasColumn('pelanggan', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_member');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            if (Schema::hasColumn('pelanggan', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('pelanggan', 'is_member')) {
                $table->dropColumn('is_member');
            }
            if (Schema::hasColumn('pelanggan', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
            if (Schema::hasColumn('pelanggan', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('pelanggan', 'email')) {
                $table->dropUnique(['email']);
                $table->dropColumn('email');
            }
        });
    }
};
