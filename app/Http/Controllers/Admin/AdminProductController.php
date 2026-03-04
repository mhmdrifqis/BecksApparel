<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'status' => 'required|in:available,unavailable',
        ]);

        // 2. Upload Gambar (Jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder: storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan Data ke Database
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5), // Slug unik
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock, // UA9: Kelola Stok
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        // UA2: Kelola Ukuran (Contoh jika input dikirim sebagai array)
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $size['name'],
                    'additional_price' => $size['price'] ?? 0
                ]);
            }
        }

        // UA2: Kelola Warna
        if ($request->has('colors')) {
            foreach ($request->colors as $color) {
                $product->colors()->create($color);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Memperbarui data produk.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'status']);
        
        // Update slug jika nama berubah
        if ($request->name !== $product->name) {
             $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        }

        // 2. Cek apakah ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Upload gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. Update Database
        $product->update($data);

        // UA2: Update Ukuran (Hapus yang lama, simpan yang baru atau gunakan sync)
        if ($request->has('sizes')) {
            $product->sizes()->delete(); // Sederhananya hapus dulu semua
            foreach ($request->sizes as $size) {
                $product->sizes()->create([
                    'size_name' => $size['name'],
                    'additional_price' => $size['price'] ?? 0
                ]);
            }
        }

        // UA2: Update Warna
        if ($request->has('colors')) {
            $product->colors()->delete();
            foreach ($request->colors as $color) {
                $product->colors()->create([
                    'color_name' => $color['name'],
                    'hex_code' => $color['hex']
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        // 1. Hapus gambar dari storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Hapus data dari database
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}