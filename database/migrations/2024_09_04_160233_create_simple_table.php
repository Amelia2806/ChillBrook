<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi.
     * Method ini akan dipanggil saat migrasi dijalankan menggunakan perintah 'php artisan migrate'.
     */
    public function up()
    {
        // Memeriksa apakah tabel 'simple' sudah ada
        if (!Schema::hasTable('simple')) {
            // Membuat tabel 'simple' jika belum ada
            Schema::create('simple', function (Blueprint $table) {
                $table->id(); // Menambahkan kolom 'id' yang merupakan primary key dan auto-increment
                $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
            });
        }
    }

    /**
     * Membalikkan migrasi.
     * Method ini akan dipanggil saat migrasi di-rollback menggunakan perintah 'php artisan migrate:rollback'.
     */
    public function down()
    {
        // Menghapus tabel 'simple' jika ada
        Schema::dropIfExists('simple');
    }
};
