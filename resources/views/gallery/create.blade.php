@extends('auth.layouts')  <!-- Menggunakan layout umum yang sudah disediakan di folder 'auth' -->

@section('content')  <!-- Mulai bagian konten utama -->
<form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf  <!-- Cross-Site Request Forgery protection, untuk mencegah serangan CSRF -->
    
    <!-- Input untuk judul gambar -->
    <div class="mb-3 row">
        <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>  <!-- Label untuk input judul -->
        <div class="col-md-6">
            <input type="text" class="form-control" id="title" name="title">  <!-- Input teks untuk judul -->
            @error('title')  <!-- Menampilkan pesan error jika validasi gagal -->
            <div class="alert alert-danger">{{ $message }}</div>  <!-- Menampilkan pesan error validasi -->
            @enderror
        </div>
    </div>

    <!-- Input untuk deskripsi gambar -->
    <div class="mb-3 row">
        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>  <!-- Label untuk input deskripsi -->
        <div class="col-md-6">
            <textarea class="form-control" id="description" rows="5" name="description"></textarea>  <!-- Textarea untuk deskripsi -->
            @error('description')  <!-- Menampilkan pesan error jika validasi gagal -->
            <div class="alert alert-danger">{{ $message }}</div>  <!-- Menampilkan pesan error validasi -->
            @enderror
        </div>
    </div>

    <!-- Input untuk memilih file gambar -->
    <div class="mb-3 row">
        <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">File input</label>  <!-- Label untuk input file -->
        <div class="col-md-6">
            <div class="input-group">  <!-- Grup input untuk menampung elemen input file -->
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="input-file" name="picture">  <!-- Input file untuk memilih gambar -->
                    <label class="custom-file-label" for="input-file">Choose file</label>  <!-- Label untuk input file -->
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol submit untuk mengirimkan form -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection  <!-- Mengakhiri bagian konten utama -->
