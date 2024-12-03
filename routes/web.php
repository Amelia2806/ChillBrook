<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PemainController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\CheckAge;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController; //mail

// Default route (halaman utama)
Route::get('/', function () {
    return view('welcome'); // Menampilkan view 'welcome'
})->name('welcome'); // Memberikan nama rute 'welcome'

// Rute untuk halaman 'about'
Route::get('/about', function () {
    return view('about', [
        "name" => "jay", // Variabel 'name' yang akan digunakan di view
        "email" => "jay@gmail.com" // Variabel 'email' yang akan digunakan di view
    ]);
});

// Rute untuk halaman index post
Route::get('/post', [PostController::class, 'index']); // Menggunakan PostController dan metode 'index'

// Rute resource untuk controller 'SimpleController'
Route::resource('simple', SimpleController::class); // Secara otomatis membuat rute CRUD untuk resource 'simple'

// Rute untuk menampilkan daftar pemain
Route::get('/pemain', [PemainController::class, 'index'])->name('pemain.index'); // Menggunakan PemainController, metode 'index'

// Rute untuk LoginRegisterController
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register'); // Form registrasi
    Route::post('/store', 'store')->name('store'); // Proses penyimpanan registrasi
    Route::get('/login', 'login')->name('login'); // Form login
    Route::post('/authenticate', 'authenticate')->name('authenticate'); // Proses autentikasi login
    Route::post('/logout', 'logout')->name('logout'); // Proses logout
    Route::get('/dashboard', 'dashboard')->name('dashboard'); // Dashboard setelah login
});

// Rute untuk Buku dan Dashboard (dengan middleware 'auth' untuk membatasi akses hanya pengguna yang login)
Route::middleware(['auth'])->group(function() {
    // Rute CRUD untuk Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index'); // Daftar buku
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create'); // Form tambah buku
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store'); // Simpan buku baru
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit'); // Form edit buku
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update'); // Update buku
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy'); // Hapus buku

    // Rute untuk Dashboard
    Route::get('/dashboard', [BukuController::class, 'dashboard'])->name('dashboard'); // Menampilkan dashboard
});

// Rute untuk halaman 'restricted', hanya dapat diakses jika middleware 'checkage' terpenuhi [middleware]
Route::get('restricted', function() {
    return redirect(route('dashboard'))->with('success', 'Anda berusia lebih dari 18 tahun!'); // Redirect ke dashboard jika lolos middleware
})->middleware('checkage');

// Resource rute untuk GalleryController
Route::resource('gallery', GalleryController::class); // Membuat semua rute CRUD secara otomatis untuk resource 'gallery'

// Rute untuk pengiriman email
Route::get('/send-mail', [SendEmailController::class, 'index'])->name('kirim-email'); // Form pengiriman email
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email'); // Proses pengiriman email
