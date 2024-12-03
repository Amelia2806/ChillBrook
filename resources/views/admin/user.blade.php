@extends('auth.layouts')

@section('content')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="row justify-content-center mt-5">
    <div class="col-md-12"> <!-- Ubah lebar kolom menjadi 10 -->
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                
                @if (auth()->user()->level == 'admin')
                    <!-- Admin Dashboard -->
                    @if ($message = Session::get('succes'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            You are logged in as Admin!
                        </div>
                    @endif

                    <!-- Tabel Data Buku -->
                    <table class="table table-bordered mt-4">
                        <thead class="table-danger">
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Harga</th>
                                <th>Tanggal Terbit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_buku as $index => $buku)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $buku->id }}</td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ "Rp. " . number_format($buku->harga, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                                    <td>
                                        <!-- Form untuk menghapus buku -->
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                                        </form>

                                        <!-- Tautan untuk mengedit buku -->
                                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p><strong>Total Buku:</strong> {{ $total_buku }}</p>
                    <p><strong>Total Harga:</strong> {{ "Rp. " . number_format($total_harga, 2, ',', '.') }}</p>
                @else
                    <!-- Non-Admin View -->
                    <div class="alert alert-warning">
                        <h1>Selamat Datang User!</h1>
                        <p>Anda bukan admin, oleh karena itu Anda tidak memiliki akses ke halaman ini.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
