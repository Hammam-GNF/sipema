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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_petugas');
            $table->unsignedBigInteger('id_pengaduan');
            $table->text('isi_laporan');
            $table->date('tanggal_laporan');
            $table->timestamps();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id_user')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
