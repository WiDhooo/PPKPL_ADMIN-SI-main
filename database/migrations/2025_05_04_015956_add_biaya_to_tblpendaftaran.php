<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->decimal('biaya', 10, 2)->nullable(); // Menambahkan kolom biaya
        });
    }

    public function down()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->dropColumn('biaya'); // Menghapus kolom biaya jika rollback
        });
    }

};
