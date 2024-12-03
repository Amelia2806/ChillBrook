<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit Buku</title>
</head>
<body>
    <div class="container mt-4">
        <h4 class="mb-4">Edit Buku</h4>
        <div class="card" style="background-color: #ffe6f2; border-color: #ff99cc;">
            <div class="card-body">
            <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $buku->id }}" style="border-color: #ff66b2;">
                    <div class="mb-3"> <!--tampilkan data yang dipilih dengan menerapkan potongan ketentuan code kedalam form edit buku-->
                        <label for="judul" class="form-label" style="color: #ff66b2;">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $buku->judul }}" style="border-color: #ff66b2;" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="penulis" class="form-label" style="color: #ff66b2;">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="{{ $buku->penulis }}" style="border-color: #ff66b2;" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label" style="color: #ff66b2;">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}" style="border-color: #ff66b2;" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tgl_terbit" class="form-label" style="color: #ff66b2;">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" style="border-color: #ff66b2;" required>
                    </div>

                    <div class="mb-3 row">
                        <label for="photo" class="col-md-4 col-form-label text-md-end text-start" style="color: #ff66b2;">Photo</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                                <span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success" style="background-color: #ff66b2; border-color: #ff66b2;">Update</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-secondary" style="background-color: #ff99cc; border-color: #ff99cc;">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
