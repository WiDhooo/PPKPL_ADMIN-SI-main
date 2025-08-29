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
        Schema::create('tblsantri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->nullable()->constrained('tblpendaftaran')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nis', 11);
            $table->string('nama_santri', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('nama_orang_tua', 100);
            $table->string('no_hp', 20);
            $table->string('akta_kelahiran', 255); // path file gambar
            $table->string('kartu_keluarga', 255); // path file gambar
            $table->timestamps(); // created_at & updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
