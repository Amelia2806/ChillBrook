@extends('auth.layouts')  <!-- Menggunakan layout umum yang sudah disediakan di folder 'auth' -->

@section('content')  <!-- Mulai bagian konten utama -->
<div class="row justify-content-center">
    <h3 class="text-center">Kirim Email</h3>  <!-- Menampilkan judul halaman Kirim Email -->
    <div class="col-md-12 p-12">
        
        {{-- Menampilkan pesan status jika ada --}}  
        @if (session('status'))  
        <div class="alert alert-primary" role="alert">  
            {{ session('status') }}  <!-- Menampilkan pesan status dari session -->
        </div>
        @endif
        
        <!-- Form untuk mengirim email -->
        <form action="{{ route('post-email') }}" method="post">
            @csrf  <!-- Cross-Site Request Forgery protection, untuk mencegah serangan CSRF -->
            
            <!-- Input untuk nama pengirim -->
            <div class="form-group">
                <label for="name">Nama</label>  <!-- Label untuk input nama -->
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama">  <!-- Input teks untuk nama -->
            </div>

            <!-- Input untuk email tujuan -->
            <div class="form-group my-3">
                <label for="email">Email Tujuan</label>  <!-- Label untuk input email tujuan -->
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Tujuan">  <!-- Input email untuk tujuan email -->
            </div>

            <!-- Input untuk subjek email -->
            <div class="form-group my-3">
                <label for="subject">Subjek</label>  <!-- Label untuk input subjek -->
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek">  <!-- Input teks untuk subjek -->
            </div>

            <!-- Input untuk body deskripsi email -->
            <div class="form-group my-3">
                <label for="body">Body Deskripsi</label>  <!-- Label untuk textarea body email -->
                <textarea name="body" class="form-control" id="body" cols="30" rows="10"></textarea>  <!-- Textarea untuk body email -->
            </div>

            <!-- Tombol kirim email -->
            <div class="form-group">
                <button class="btn btn-primary">Kirim Email</button>  <!-- Tombol untuk mengirim email -->
            </div>
        </form>
    </div>
</div>
@endsection  <!-- Mengakhiri bagian konten utama -->
