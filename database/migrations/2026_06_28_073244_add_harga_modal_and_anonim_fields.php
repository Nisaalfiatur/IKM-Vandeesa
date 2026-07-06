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
        Schema::table('item', function (Blueprint $table) {
            $table->double('harga_modal')->nullable()->after('harga_reseller');
        });

        Schema::table('detail_invoice', function (Blueprint $table) {
            $table->double('harga_modal')->nullable()->after('harga_perpcs');
        });

        Schema::table('invoice', function (Blueprint $table) {
            $table->string('nama_pelanggan_anonim')->nullable()->after('id_reseller');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('harga_modal');
        });

        Schema::table('detail_invoice', function (Blueprint $table) {
            $table->dropColumn('harga_modal');
        });

        Schema::table('invoice', function (Blueprint $table) {
            $table->dropColumn('nama_pelanggan_anonim');
        });
    }
};
