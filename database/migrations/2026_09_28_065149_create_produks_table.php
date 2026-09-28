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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_product');
            $table->foreignId('penjual_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nama_product');
            $table->text('deskripsi')->nullable();
            $table->bigInteger('harga');
            $table->integer('stok')->default(0);
            $table->string('kategori')->nullable();
            $table->string('gambar_product')->nullable();
            $table->enum('status_product', ['tersedia', 'habis'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
