// database/migrations/[timestamp]_add_profile_columns_to_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom hanya jika belum ada
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('password');
            });
        }

        if (!Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable()->after('phone');
            });
        }

        // Buat tabel user_profiles jika belum ada
        if (!Schema::hasTable('user_profiles')) {
            Schema::create('user_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->text('bio')->nullable();
                $table->boolean('subscribe_newsletter')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom jika ada
        if (Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('phone');
            });
        }

        if (Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }

        // Hapus tabel user_profiles jika ada
        Schema::dropIfExists('user_profiles');
    }
};
