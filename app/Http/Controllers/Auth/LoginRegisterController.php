<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Buku; // Import model Buku
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserRegisteredEmail; // Menggunakan class untuk mengirim email
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        // Middleware 'guest' memastikan hanya pengguna yang belum login bisa mengakses halaman tertentu,
        // kecuali untuk 'logout' dan 'dashboard'
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    public function register()
    {
        // Menampilkan form registrasi
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form registrasi
        $validatedData = $request->validate([
            'name' => 'required|string|max:250', // Nama wajib, harus berupa string, maksimum 250 karakter
            'email' => 'required|email|max:250|unique:users,email', // Email wajib, valid, unik
            'password' => 'required|min:8|confirmed' // Password wajib, minimal 8 karakter, dan cocok dengan konfirmasi password
        ]);

        // Membuat user baru di database
        $user = User::create([
            'name' => $validatedData['name'], // Menyimpan nama
            'email' => $validatedData['email'], // Menyimpan email
            'password' => Hash::make($validatedData['password']), // Menyimpan password yang sudah di-hash
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Regenerasi session untuk mencegah fixation attack
        $request->session()->regenerate();

        // Mengirim email selamat datang
        Mail::to($validatedData['email'])->send(new UserRegisteredEmail($validatedData));

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Anda berhasil mendaftar & masuk!');
    }

    public function login()
    {
        // Menampilkan form login
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validasi data login
        $credentials = $request->validate([
            'email' => 'required|email', // Email wajib dan harus valid
            'password' => 'required' // Password wajib
        ]);

        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            // Jika login berhasil, regenerasi session untuk keamanan
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Anda berhasil masuk!');
        }

        // Jika login gagal, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Kredensial yang Anda berikan tidak cocok.'
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            // Ambil semua data buku
            $data_buku = Buku::all();
            // Tampilkan halaman dashboard dengan data buku
            return view('auth.dashboard', compact('data_buku'));
        }

        // Redirect ke halaman login jika belum login
        return redirect()->route('login')->withErrors([
            'email' => 'Silakan masuk untuk mengakses dashboard.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();

        // Regenerasi token CSRF
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar!');
    }

    // ---- Bagian CRUD Buku ----

    public function index()
    {
        // Ambil semua data buku dari database
        $data_buku = Buku::all();
        // Tampilkan halaman index buku dengan data buku
        return view('buku.index', compact('data_buku'));
    }

    public function create()
    {
        // Menampilkan form untuk membuat buku baru
        return view('buku.create');
    }

    public function storeBuku(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255', // Judul wajib, string, maksimum 255 karakter
            'penulis' => 'required|string|max:255', // Penulis wajib, string, maksimum 255 karakter
            'harga' => 'required|numeric', // Harga wajib, angka
            'tgl_terbit' => 'required|date' // Tanggal terbit wajib, harus berupa tanggal
        ]);

        // Simpan data buku baru ke database
        Buku::create($validatedData);

        // Redirect ke halaman index buku dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Cari buku berdasarkan ID
        $buku = Buku::findOrFail($id);
        // Tampilkan form edit buku dengan data buku yang dipilih
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim dari form
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255', // Judul wajib, string, maksimum 255 karakter
            'penulis' => 'required|string|max:255', // Penulis wajib, string, maksimum 255 karakter
            'harga' => 'required|numeric', // Harga wajib, angka
            'tgl_terbit' => 'required|date' // Tanggal terbit wajib, harus berupa tanggal
        ]);

        // Cari buku berdasarkan ID dan perbarui data
        $buku = Buku::findOrFail($id);
        $buku->update($validatedData);

        // Redirect ke halaman index buku dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari buku berdasarkan ID
        $buku = Buku::findOrFail($id);

        // Hapus buku dari database
        $buku->delete();

        // Redirect ke halaman index buku dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
