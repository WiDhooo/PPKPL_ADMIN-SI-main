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
        Schema::create('tblpendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_santri', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('nama_orang_tua', 100);
            $table->string('no_hp', 15);
            $table->string('akta_kelahiran', 255); // path file gambar
            $table->string('kartu_keluarga', 255); // path file gambar
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps(); // created_at & updated_at
            $table->string('snap_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpendaftaran');
    }
};
