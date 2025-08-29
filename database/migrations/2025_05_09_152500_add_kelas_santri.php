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
        Schema::table('tblsantri', function (Blueprint $table) {
            $table->foreignId('id_kelas')->nullable()->constrained('tblkelas')->onDelete('cascade')->onUpdate('cascade')->after('kartu_keluarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tblsantri', function (Blueprint $table) {
            $table->dropColumn('id_kelas');
        });
    }
};
