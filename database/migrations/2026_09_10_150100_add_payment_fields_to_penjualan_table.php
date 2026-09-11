<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualan', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->default('CASH')->after('status');
            }
            if (!Schema::hasColumn('penjualan', 'total_pembayaran')) {
                $table->decimal('total_pembayaran', 15, 2)->default(0)->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('penjualan', 'uang_bayar')) {
                $table->decimal('uang_bayar', 15, 2)->nullable()->after('total_pembayaran');
            }
            if (!Schema::hasColumn('penjualan', 'kembalian')) {
                $table->decimal('kembalian', 15, 2)->nullable()->after('uang_bayar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'total_pembayaran', 'uang_bayar', 'kembalian']);
        });
    }
};