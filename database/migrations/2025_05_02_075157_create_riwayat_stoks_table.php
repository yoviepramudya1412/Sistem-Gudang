<?php

// database/migrations/2024_05_01_000005_create_riwayat_stok_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('mutasi_id')->nullable()->constrained('mutasi_barang');
            $table->integer('stok_sebelumnya');
            $table->integer('perubahan_stok');
            $table->integer('stok_sekarang');
            $table->string('tipe_perubahan');
            $table->foreignId('pengguna_id')->constrained('pengguna');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_stok');
    }
};
