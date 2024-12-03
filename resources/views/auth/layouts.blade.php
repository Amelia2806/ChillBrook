<!DOCTYPE html>
<html lang="en"> <!-- Menentukan bahasa dokumen -->

<head>
    <meta charset="UTF-8"> <!-- Menentukan karakter encoding dokumen -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat tampilan responsif pada perangkat -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> <!-- Mengatur kompatibilitas Internet Explorer -->
    <title>Buku</title> <!-- Judul halaman -->

    <!-- Menyisipkan CSS Bootstrap untuk desain -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Menyisipkan CSS untuk lightbox (efek gambar) -->
    <link rel="stylesheet" href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}">
</head>

<body>
    <!-- Membuat navigasi utama -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container"> <!-- Container untuk konten navbar -->
            <a class="navbar-brand" href="{{ URL('/') }}">Custom Login Register</a> <!-- Link ke halaman utama -->

            <!-- Tombol untuk tampilan mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> <!-- Ikon toggle -->
            </button>

            <!-- Menu navigasi -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto"> <!-- Daftar menu dengan margin kiri otomatis -->

                    <!-- Menu gallery -->
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('gallery')) ? 'active' : '' }}" href="{{ route('gallery.index') }}">Gallery</a>
                    </li>

                    <!-- Menu send mail -->
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('send-mail')) ? 'active' : '' }}" href="{{ route('kirim-email') }}">Send Mail</a>
                    </li>

                    <!-- Menu untuk pengguna yang belum login -->
                    @guest 
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <!-- Menu dropdown untuk pengguna yang sudah login -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }} <!-- Menampilkan nama pengguna yang login -->
                            </a>
                            <ul class="dropdown-menu"> <!-- Daftar dropdown -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    <!-- Form logout -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf <!-- Token keamanan -->
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container utama untuk konten -->
    <div class="container">
        @yield('content') <!-- Tempat untuk memasukkan konten dari halaman lain -->
    </div>

    <!-- Menyisipkan script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Menyisipkan script untuk lightbox -->
    <script src="{{ asset('lightbox2/dist/js/lightbox-plus-jquery.min.js') }}"></script>
</body>

</html>