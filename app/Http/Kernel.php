<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * Middleware ini dijalankan selama setiap request ke aplikasi Anda.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, // Middleware untuk memverifikasi host yang dipercaya, bisa diaktifkan jika diperlukan.
        \App\Http\Middleware\TrustProxies::class, // Middleware untuk menangani proxy yang dipercaya, umumnya digunakan dalam aplikasi yang di-deploy di balik proxy seperti load balancer.
        \Illuminate\Http\Middleware\HandleCors::class, // Middleware untuk menangani Cross-Origin Resource Sharing (CORS), memungkinkan request dari domain yang berbeda.
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // Middleware untuk mencegah request saat aplikasi dalam mode pemeliharaan.
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Middleware untuk memvalidasi ukuran request POST yang dikirim, menghindari file terlalu besar.
        \App\Http\Middleware\TrimStrings::class, // Middleware untuk memangkas spasi di awal dan akhir input string.
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Middleware untuk mengonversi string kosong menjadi nilai null.
    ];

    /**
     * The application's route middleware groups.
     *
     * Mengelompokkan middleware berdasarkan jenis rute.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class, // Middleware untuk mengenkripsi cookies agar aman.
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // Middleware untuk menambahkan cookies yang antri dalam response.
            \Illuminate\Session\Middleware\StartSession::class, // Middleware untuk memulai sesi untuk user yang login.
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Middleware untuk membagikan error session agar dapat ditampilkan dalam tampilan.
            \App\Http\Middleware\VerifyCsrfToken::class, // Middleware untuk memverifikasi token CSRF pada request untuk mencegah serangan CSRF.
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Middleware untuk menggantikan binding route yang telah didefinisikan.
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Middleware yang memastikan request frontend tetap berbasis sesi di API (komentar jika menggunakan Sanctum).
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api', // Middleware untuk membatasi jumlah request yang dapat dilakukan ke API.
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Middleware untuk menggantikan binding route pada API.
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases ini dapat digunakan untuk merujuk middleware dalam rute dan grup middleware.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class, // Middleware untuk memverifikasi apakah pengguna sudah terautentikasi.
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Middleware untuk autentikasi menggunakan HTTP basic auth.
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // Middleware untuk memverifikasi sesi autentikasi pengguna.
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Middleware untuk mengatur header cache pada response.
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Middleware untuk memverifikasi izin akses berdasarkan kebijakan (policies).
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Middleware untuk mengalihkan pengguna yang sudah login ke halaman lain.
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // Middleware untuk memverifikasi apakah pengguna sudah mengonfirmasi password mereka.
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // Middleware untuk menangani permintaan precognitive (permintaan masa depan) dalam aplikasi.
        'signed' => \App\Http\Middleware\ValidateSignature::class, // Middleware untuk memvalidasi tanda tangan URL.
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Middleware untuk membatasi jumlah permintaan ke aplikasi.
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Middleware untuk memastikan email pengguna telah diverifikasi.
        'checkage'=>\App\Http\Middleware\CheckAge::class, // Middleware custom yang memverifikasi usia pengguna sebelum mengakses suatu halaman (misalnya untuk konten dewasa).
        'admin' => \App\Http\Middleware\Admin::class, // Middleware custom untuk memverifikasi apakah pengguna adalah admin.
    ];
}
