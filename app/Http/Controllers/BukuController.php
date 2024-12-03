<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // Menambahkan middleware auth di konstruktor
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth')->except(['showLoginForm', 'login']); // Hanya user yang terautentikasi yang dapat mengakses metode ini, kecuali showLoginForm dan login
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan Anda memiliki view untuk login
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Autentikasi sukses
            return redirect()->route('buku.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Fungsi untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Pastikan ini mengarah ke route login Anda
    }

    public function index()
    {
        // Mengambil semua data buku dengan urutan berdasarkan ID dari yang terbaru
        $data_buku = Buku::orderBy('id', 'desc')->get();

        // Menghitung jumlah total buku
        $total_buku = $data_buku->count();

        // Menghitung jumlah total harga buku
        $total_harga = $data_buku->sum('harga');

        // Mengirim data buku, total buku, dan total harga ke view
        return view('buku.index', compact('data_buku', 'total_buku', 'total_harga'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'photo' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan);
        }        

        $buku = new Buku;
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->photo = $path ?? null;
        $buku->save();
        
        return redirect()->route('dashboard')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id) 
    {
        // Cari buku berdasarkan ID
        $buku = Buku::find($id);

        // Jika buku tidak ditemukan, redirect dengan pesan error
        if (!$buku) {
            return redirect()->route('dashboard')->with('error', 'Buku tidak ditemukan!');
        }

        // Arahkan ke view edit.blade.php dengan data buku yang akan diedit
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
{
    // Validasi data
    $request->validate([
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'tgl_terbit' => 'required|date',
        'photo' => 'image|nullable|max:1999',
    ]);

    // Temukan buku berdasarkan ID
    $buku = Buku::findOrFail($id);

    // Update kolom data buku
    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;
    $buku->tgl_terbit = $request->tgl_terbit;

    // Cek apakah ada file baru yang diunggah
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($buku->photo && Storage::exists($buku->photo)) {
            Storage::delete($buku->photo);
        }

        // Simpan foto baru
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('photo')->storeAs('photos', $filenameSimpan);

        // Update kolom photo dengan path baru
        $buku->photo = $path;
    }

    // Simpan perubahan ke database
    $buku->save();

    // Redirect atau respons sesuai kebutuhan
    return redirect()->route('dashboard')->with('success', 'Data buku berhasil diperbarui');
}


    // public function update(Request $request, $id) 
    // {
        
    //     // Validasi input
    //     $request->validate([
    //         'judul' => 'required|string|max:255',
    //         'penulis' => 'required|string|max:255',
    //         'harga' => 'required|numeric',
    //         'tgl_terbit' => 'required|date',
    //         'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //         // 'photo' => 'image|nullable|max:1999'
    //     ]);

    //     if ($request->hasFile('picture')) {
    //         // ada file yang diupload
    //     } else {
    //         // tidak ada file yang diupload
    //     }

    //     // Mencari buku yang akan diupdate
    //     $buku = Buku::find($id);

    //     if (!$buku) {
    //         return redirect()->route('buku.index')->with('error', 'Buku tidak ditemukan!');
    //     }

    //     // Update data buku
    //     $buku->judul = $request->judul;
    //     $buku->penulis = $request->penulis;
    //     $buku->harga = $request->harga;
    //     $buku->tgl_terbit = $request->tgl_terbit;
    //     $buku->save();

    //     return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    // }

    public function destroy($id)
    {
        // Cari buku berdasarkan ID
        $buku = Buku::find($id);

        if ($buku) {
            $buku->delete();
            return redirect()->route('dashboard')->with('success', 'Buku berhasil dihapus!');
        }

        return redirect()->route('dashboard')->with('error', 'Buku tidak ditemukan!');
    }

    public function dashboard()
{
    // Mengambil semua data buku dengan urutan berdasarkan ID dari yang terbaru
    $data_buku = Buku::orderBy('id', 'desc')->get();

    // Menghitung jumlah total buku
    $total_buku = $data_buku->count();

    // Menghitung jumlah total harga buku
    $total_harga = $data_buku->sum('harga');

    // Mengirim data buku, total buku, dan total harga ke view
    return view('auth.dashboard', compact('data_buku', 'total_buku', 'total_harga'));
}

}
