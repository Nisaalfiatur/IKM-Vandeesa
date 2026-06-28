<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop FK dengan nama asli dari MySQL
        try {
            DB::statement('ALTER TABLE `delivery` DROP FOREIGN KEY `delivery_ibfk_1`');
        } catch (\Exception $e) {}

        // Modify kolom id_reseller menjadi nullable
        DB::statement('ALTER TABLE `delivery` MODIFY `id_reseller` varchar(10) NULL');

        // Tambah kembali FK dengan ON DELETE SET NULL
        try {
            DB::statement('ALTER TABLE `delivery` ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`id_reseller`) REFERENCES `reseller` (`id_reseller`) ON DELETE SET NULL ON UPDATE RESTRICT');
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `delivery` DROP FOREIGN KEY `delivery_ibfk_1`');
        } catch (\Exception $e) {}

        DB::statement('ALTER TABLE `delivery` MODIFY `id_reseller` varchar(10) NOT NULL');

        try {
            DB::statement('ALTER TABLE `delivery` ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`id_reseller`) REFERENCES `reseller` (`id_reseller`) ON DELETE RESTRICT ON UPDATE RESTRICT');
        } catch (\Exception $e) {}
    }
};
