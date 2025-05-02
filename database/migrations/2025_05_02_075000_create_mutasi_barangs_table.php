<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mutasi_barang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mutasi');
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('pengguna_id')->constrained('pengguna');
            $table->enum('jenis_mutasi', ['masuk', 'keluar', 'pemindahan', 'penyesuaian']);
            $table->integer('jumlah');
            $table->foreignId('lokasi_asal_id')->nullable()->constrained('lokasi');
            $table->foreignId('lokasi_tujuan_id')->nullable()->constrained('lokasi');
            $table->string('nomor_referensi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->enum('status', ['draft', 'diproses', 'selesai', 'dibatalkan'])->default('diproses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mutasi_barang');
    }
};
