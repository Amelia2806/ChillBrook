@extends('auth.layouts') <!-- Menggunakan layout utama dari 'auth.layouts'-->

@section('content') <!-- Bagian konten yang akan dimasukkan ke dalam layout -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!--Menyisipkan CSS Bootstrap-->

<div class="row justify-content-center mt-5"> <!-- Membuat baris dengan margin atas dan memusatkan konten -->
    <div class="col-md-15"> <!-- Menentukan lebar kolom untuk tampilan -->
        <div class="card"> <!-- Membuat sebuah kartu -->
            <div class="card-header">Dashboard</div> <!-- Header kartu dengan teks 'Dashboard' -->
            <div class="card-body"> <!-- Bagian utama dari kartu -->

                @if ($message = Session::get('success')) 
                    <!-- Jika ada pesan sukses di session -->
                    <div class="alert alert-success">
                        {{ $message }} <!-- Menampilkan pesan sukses -->
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in! <!-- Pesan default jika tidak ada pesan sukses -->
                    </div>
                @endif

                <!-- Tombol untuk menambah buku -->
                <a href="{{ route('buku.create') }}" class="btn btn-primary float-end mb-3">Tambah Buku</a>
                <h3 class="mt-4">Data Buku</h3> <!-- Judul bagian tabel -->

                <!-- Tabel Data Buku -->
                <table class="table table-bordered mt-4"> <!-- Membuat tabel dengan garis pembatas -->
                    <thead class="table-danger"> <!-- Bagian header tabel dengan warna latar merah -->
                        <tr>
                            <th>No</th> <!-- Kolom nomor urut -->
                            <th>ID</th> <!-- Kolom ID buku -->
                            <th>Judul Buku</th> <!-- Kolom judul buku -->
                            <th>Penulis</th> <!-- Kolom penulis buku -->
                            <th>Harga</th> <!-- Kolom harga buku -->
                            <th>Tanggal Terbit</th> <!-- Kolom tanggal terbit -->
                            <th>Photo</th> <!-- Kolom foto buku -->
                            <th>Aksi</th> <!-- Kolom untuk tindakan edit/hapus -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_buku as $index => $buku) 
                            <!-- Looping untuk setiap data buku -->
                            <tr>
                                <td>{{ $index + 1 }}</td> <!-- Menampilkan nomor urut -->
                                <td>{{ $buku->id }}</td> <!-- Menampilkan ID buku -->
                                <td>{{ $buku->judul }}</td> <!-- Menampilkan judul buku -->
                                <td>{{ $buku->penulis }}</td> <!-- Menampilkan penulis buku -->
                                <td>{{ "Rp. " . number_format($buku->harga, 2, ',', '.') }}</td> <!-- Format harga -->
                                <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td> <!-- Format tanggal -->
                                <td>
                                    <!-- Menampilkan gambar jika tersedia -->
                                    @if($buku->photo)
                                        <img src="{{ asset('storage/' . $buku->photo) }}" alt="Gambar Buku" width="200"> <!-- Menampilkan foto -->
                                    @else
                                        <span>Tidak ada gambar</span> <!-- Pesan jika tidak ada foto -->
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol edit -->
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Form untuk menghapus buku -->
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                        @csrf <!-- Token CSRF untuk keamanan -->
                                        @method('DELETE') <!-- Metode DELETE -->
                                        <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button> <!-- Tombol hapus -->
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Menampilkan total buku dan total harga -->
                <p><strong>Total Buku:</strong> {{ $total_buku }}</p> <!-- Total jumlah buku -->
                <p><strong>Total Harga:</strong> {{ "Rp. " . number_format($total_harga, 2, ',', '.') }}</p> <!-- Total harga buku -->
            </div>
        </div>
    </div>
</div>
@endsection <!-- Penutup bagian konten -->
