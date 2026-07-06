<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('invoice', 'id_pelanggan')) {
            return;
        }

        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'invoice'
              AND COLUMN_NAME = 'id_pelanggan'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE `invoice` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
        }

        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('id_pelanggan');
        });
    }

    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('id_pelanggan', 10)->nullable()->after('no_invoice');
        });
    }
};
