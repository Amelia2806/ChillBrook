@extends('auth.layouts') <!-- Menggunakan layout 'auth.layouts' untuk halaman login -->

@section('content') <!-- Menentukan bagian konten utama halaman -->

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div> <!-- Header card untuk halaman login -->
            <div class="card-body">
                <form action="{{ route('authenticate') }}" method="post"> <!-- Formulir untuk mengirim data ke route 'authenticate' -->
                    @csrf <!-- Menambahkan token CSRF untuk melindungi formulir dari serangan CSRF -->
                    
                    <!-- Input untuk alamat email -->
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label> <!-- Label untuk email -->
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"> <!-- Input email dengan validasi error -->
                            @if ($errors->has('email')) <!-- Mengecek apakah ada error pada kolom email -->
                                <span class="text-danger">{{ $errors->first('email') }}</span> <!-- Menampilkan pesan error jika ada -->
                            @endif
                        </div>
                    </div>

                    <!-- Input untuk password -->
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label> <!-- Label untuk password -->
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"> <!-- Input password dengan validasi error -->
                            @if ($errors->has('password')) <!-- Mengecek apakah ada error pada kolom password -->
                                <span class="text-danger">{{ $errors->first('password') }}</span> <!-- Menampilkan pesan error jika ada -->
                            @endif
                        </div>
                    </div>

                    <!-- Tombol submit untuk login -->
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login"> <!-- Tombol untuk mengirim formulir login -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection <!-- Menutup bagian konten utama halaman -->