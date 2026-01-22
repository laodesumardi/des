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
        Schema::create('pengajuan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik', 16);
            $table->string('telepon');
            $table->text('alamat');
            $table->string('jenis_layanan');
            $table->string('berkas')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['masuk', 'diproses', 'selesai', 'ditolak'])->default('masuk');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('diproses_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_layanan');
    }
};
