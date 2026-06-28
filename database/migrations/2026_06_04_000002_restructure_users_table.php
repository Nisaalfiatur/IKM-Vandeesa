<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign keys if any
        Schema::table('users', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn(['name', 'email', 'email_verified_at', 'remember_token']);
        });

        // Rename primary key dari 'id' to 'id_user'
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'id_user');
        });

        // Add required columns
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('id_user');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('password');
            }
        });

        // Make sure timestamps are gone if they exist
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role']);
            $table->renameColumn('id_user', 'id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
};
