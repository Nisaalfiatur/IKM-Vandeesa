<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('id_member', 20)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->string('id_member', 10)->nullable(false)->change();
        });
    }
};
