<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Buku - Dashboard</title>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if ($message = Session::get('succes'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @else
                            <div class="alert alert-success">
                                You are logged in!
                            </div>
                        @endif

                        <!-- Tombol Tambah Buku -->
                        <a href="{{ route('buku.create') }}" class="btn btn-primary float-end mb-3">Tambah Buku</a>

                        <!-- Tabel Data Buku -->
                        <table class="table table-bordered">
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
                                <!-- Looping Data Buku -->
                                @foreach($data_buku as $index => $buku)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $buku->id }}</td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>{{ $buku->penulis }}</td>
                                        <td>{{ "Rp. " . number_format($buku->harga, 2, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                                        <td>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                                            </form>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit</a>

                                            <!-- Tombol Lihat Detail -->
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" 
                                                onclick="showDetail('{{ $buku->judul }}', '{{ $buku->penulis }}', '{{ number_format($buku->harga, 2, ',', '.') }}', '{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}')">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Total Buku dan Total Harga -->
                        <p><strong>Total Buku:</strong> {{ $total_buku }}</p>
                        <p><strong>Total Harga:</strong> {{ "Rp. " . number_format($total_harga, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menampilkan detail buku -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Judul:</strong> <span id="modalJudul"></span></p>
                        <p><strong>Penulis:</strong> <span id="modalPenulis"></span></p>
                        <p><strong>Harga:</strong> <span id="modalHarga"></span></p>
                        <p><strong>Tanggal Terbit:</strong> <span id="modalTanggalTerbit"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script untuk menampilkan detail buku -->
    <script>
        function showDetail(judul, penulis, harga, tanggalTerbit) {
            document.getElementById('modalJudul').innerText = judul;
            document.getElementById('modalPenulis').innerText = penulis;
            document.getElementById('modalHarga').innerText = "Rp. " + harga;
            document.getElementById('modalTanggalTerbit').innerText = tanggalTerbit;
        }
    </script>

    <!-- Bootstrap 5 JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
