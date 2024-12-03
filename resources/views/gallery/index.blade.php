@extends('auth.layouts')  <!-- Menggunakan layout umum yang sudah disediakan di folder 'auth' -->

@section('content')  <!-- Mulai bagian konten utama -->
<div class="row justify-content-center mt-5"> <!-- Mengatur layout agar konten terpusat secara vertikal dan horizontal -->
    <div class="col-md-8">  <!-- Mengatur ukuran kolom untuk menampung card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between">  <!-- Menyusun header card dengan dua elemen: judul dan tombol -->
                <span>Dashboard</span>  <!-- Judul halaman -->
                <!-- Tombol Create -->
                <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm">Create New Image</a> <!-- Tombol untuk menuju halaman create -->
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Mengecek apakah ada galeri yang tersedia -->
                    @if(count($galleries) > 0)
                        <!-- Menampilkan setiap galeri dalam bentuk kolom grid -->
                        @foreach($galleries as $gallery)
                            <div class="col-sm-3 mb-4"> <!-- Setiap gambar akan tampil dalam kolom kecil (1/4 lebar layar) -->
                                <div>
                                    <!-- Link untuk menampilkan gambar dalam lightbox -->
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <!-- Gambar thumbnail yang akan ditampilkan -->
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="image-{{ $gallery->id }}" />
                                    </a>
                                    <div class="d-flex justify-content-between">
                                        <!-- Tombol Edit untuk menuju halaman edit gambar -->
                                        <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        
                                        <!-- Tombol Delete untuk menghapus gambar -->
                                        <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display: inline;">
                                            @csrf  <!-- Cross-site request forgery (CSRF) protection -->
                                            @method('DELETE')  <!-- Menyatakan bahwa form ini adalah untuk method DELETE -->
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>  <!-- Tombol delete dengan konfirmasi -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>  <!-- Jika tidak ada galeri yang ditemukan -->
                    @endif
                    <!-- Menampilkan pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $galleries->links() }}  <!-- Link untuk navigasi antar halaman galeri -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  <!-- Mengakhiri bagian konten utama -->
