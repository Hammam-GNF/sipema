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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->increments('id_pengaduan');
            $table->text('deskripsi');
            $table->enum('status', ['terbuka', 'proses', 'selesai']);
            $table->unsignedInteger('id_petugas');
            $table->unsignedInteger('id_kategori');
            $table->timestamps();

            $table->foreign('id_petugas')->references('id_petugas')->on('petugas');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
