<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategori_barang');
            $table->foreignId('lokasi_id')->constrained('lokasi');
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(0);
            $table->string('satuan')->default('pcs');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->string('merek')->nullable();
            $table->string('nomor_seri')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'kadaluarsa'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
};
