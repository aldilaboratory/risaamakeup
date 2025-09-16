<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('packages', function (Blueprint $table) {
            // hapus unique lama di slug (jika ada)
            try { $table->dropUnique('packages_slug_unique'); } catch (\Throwable $e) {}
            // atau: $table->dropUnique(['slug']);

            // buat unique gabungan
            $table->unique(['category_id', 'slug'], 'packages_category_slug_unique');
        });
    }

    public function down(): void {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropUnique('packages_category_slug_unique');
            $table->unique('slug'); // balik ke unique global jika perlu
        });
    }
};
