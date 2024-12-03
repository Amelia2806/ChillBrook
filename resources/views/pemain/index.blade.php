{{-- resources/views/pemain/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Data Pemain</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pemain</th>
                    <th>No Punggung</th>
                    <th>Posisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemain as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>{{ $player->nama_pemain }}</td>
                        <td>{{ $player->no_punggung }}</td>
                        <td>{{ $player->posisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
