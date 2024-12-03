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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->string('judul'); // Kolom untuk judul buku
            $table->string('penulis'); // Kolom untuk penulis buku
            $table->integer('harga'); // Kolom untuk jumlah stok buku
            $table->date('tgl_terbit'); 
            $table->timestamps(); // Kolom created_at dan updated_at
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
