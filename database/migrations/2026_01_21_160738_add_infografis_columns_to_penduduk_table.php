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
        Schema::table('penduduk', function (Blueprint $table) {
            $table->string('agama')->nullable()->after('pendidikan');
            $table->string('pekerjaan')->nullable()->after('agama');
            $table->string('status_perkawinan')->nullable()->after('pekerjaan');
            $table->string('kewarganegaraan')->default('WNI')->after('status_perkawinan');
            $table->string('dusun')->nullable()->after('kewarganegaraan');
            $table->string('status_dalam_keluarga')->nullable()->after('dusun');
            $table->string('no_kk', 16)->nullable()->after('nik');
            $table->boolean('is_kepala_keluarga')->default(false)->after('status_dalam_keluarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn([
                'agama',
                'pekerjaan', 
                'status_perkawinan',
                'kewarganegaraan',
                'dusun',
                'status_dalam_keluarga',
                'no_kk',
                'is_kepala_keluarga'
            ]);
        });
    }
};
