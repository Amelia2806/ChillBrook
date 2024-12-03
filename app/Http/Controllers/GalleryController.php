<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class GalleryController extends Controller
{
    // Method untuk API Gallery
    /**
     * API Endpoint: Menampilkan data gallery dalam format JSON.
     *
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"Gallery"},
     *     summary="Retrieve gallery data",
     *     description="Get all gallery posts with images.",
     *     operationId="getGallery",
     *     @OA\Response(
     *         response=200,
     *         description="List of galleries retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="picture_url", type="string", format="url"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function apiIndex()
    {
        // Mengambil data galeri yang memiliki gambar, dengan kondisi picture tidak kosong dan tidak null
        $galleries = Post::where('picture', '!=', '')
                         ->whereNotNull('picture')
                         ->orderBy('created_at', 'desc')
                         ->get() // Mengambil semua data galeri yang memenuhi syarat
                         ->map(function ($post) {
                             // Memformat data galeri menjadi array yang sesuai untuk JSON response
                             return [
                                 'id' => $post->id,
                                 'title' => $post->title,
                                 'description' => $post->description,
                                 'picture_url' => url('storage/posts_image/' . $post->picture), // URL gambar
                                 'created_at' => $post->created_at,
                                 'updated_at' => $post->updated_at,
                             ];
                         });

        // Mengembalikan data galeri dalam format JSON dengan status 200 OK
        return response()->json($galleries, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()//Gallery
    {
        // Mendapatkan data galeri yang memiliki gambar dan mengurutkan berdasarkan tanggal dibuat, dengan pagination 30 item per halaman
        $data = array(
            'id' => "posts",
            'menu' => "Gallery",
            'galleries' => Post::where('picture', '!=', '')
                            ->whereNotNull('picture')
                            ->orderBy('created_at', 'desc')
                            ->paginate(30) // Pagination untuk membatasi tampilan galeri
        );
        // Mengembalikan data ke view gallery.index
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat galeri baru
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999' // Validasi gambar dengan ukuran maksimal 1999 KB
        ]);

        // Menyimpan gambar ke storage jika ada file yang diunggah
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            // Menyimpan gambar di folder posts_image
            $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png'; // Gambar default jika tidak ada gambar
        }

        // Menyimpan data galeri ke database
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save(); // Menyimpan data ke tabel Post

        // Redirect ke halaman gallery dengan pesan sukses
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Metode ini bisa diimplementasikan jika diperlukan, untuk menampilkan satu galeri berdasarkan ID
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Menemukan galeri berdasarkan ID dan menampilkan form untuk mengedit
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validasi gambar
        ]);

        // Menemukan galeri yang ingin diupdate
        $gallery = Post::findOrFail($id);
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');

        // Jika ada gambar baru yang diunggah
        if ($request->hasFile('picture')) {
            // Menghapus gambar lama dari storage jika ada
            if ($gallery->picture && file_exists(storage_path('app/public/posts_image/' . $gallery->picture))) {
                unlink(storage_path('app/public/posts_image/' . $gallery->picture));
            }

            // Menyimpan gambar baru
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('posts_image', $filenameSimpan);

            // Memperbarui nama gambar pada galeri
            $gallery->picture = $filenameSimpan;
        }

        $gallery->save(); // Menyimpan perubahan

        // Redirect ke halaman gallery dengan pesan sukses
        return redirect()->route('gallery.index')->with('success', 'Image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menemukan galeri yang ingin dihapus
        $gallery = Post::findOrFail($id);

        // Menghapus gambar dari storage jika ada
        if ($gallery->picture && file_exists(storage_path('app/public/posts_image/' . $gallery->picture))) {
            unlink(storage_path('app/public/posts_image/' . $gallery->picture));
        }

        // Menghapus data galeri dari database
        $gallery->delete();

        // Redirect ke halaman gallery dengan pesan sukses
        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully');
    }
}
