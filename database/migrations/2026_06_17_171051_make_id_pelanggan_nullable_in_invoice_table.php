<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop FK dengan nama asli dari MySQL (bukan nama konvensi Laravel)
        try {
            DB::statement('ALTER TABLE `invoice` DROP FOREIGN KEY `invoice_ibfk_3`');
        } catch (\Exception $e) {
            // FK mungkin sudah tidak ada, lanjutkan
        }

        // Modify kolom id_pelanggan menjadi nullable
        DB::statement('ALTER TABLE `invoice` MODIFY `id_pelanggan` varchar(10) NULL');

        // Tambah kembali FK dengan ON DELETE SET NULL
        try {
            DB::statement('ALTER TABLE `invoice` ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE RESTRICT');
        } catch (\Exception $e) {
            // Jika FK sudah ada
        }
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `invoice` DROP FOREIGN KEY `invoice_ibfk_3`');
        } catch (\Exception $e) {}

        DB::statement('ALTER TABLE `invoice` MODIFY `id_pelanggan` varchar(10) NOT NULL');

        try {
            DB::statement('ALTER TABLE `invoice` ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE RESTRICT');
        } catch (\Exception $e) {}
    }
};
