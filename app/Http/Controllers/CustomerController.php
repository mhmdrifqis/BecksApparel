<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CustomerController extends Controller
{
    // UC5: Lihat Produk (Publik)
    public function index()
    {
        $products = Product::where('status', 'available')->latest()->get();
        return view('customer.products.index', compact('products'));
    }

    // UC5: Lihat Detail Produk (Publik)
    public function show(Product $product)
    {
        return view('customer.products.show', compact('product'));
    }

    // UC5: Buka Canvas Editor untuk produk tertentu
    public function design(Product $product)
    {
        return view('customer.editor', compact('product')); 
    }

    public function orders()
    {
        // Menampilkan daftar pesanan
        $orders = auth()->user()->orders()->latest()->get();
        return view('customer.orders', compact('orders')); 
    }

    public function showOrder(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load(['items.product', 'payment']);
        return view('customer.orders.show', compact('order'));
    }

    public function returns()
    {
        return view('customer.returns');
    }

    public function cart()
    {
        $cart = \App\Models\Cart::with(['items.product', 'items.design'])->firstOrCreate(['user_id' => auth()->id()]);
        
        $subtotal = $cart->items->sum(function($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });

        $total = $subtotal; // Tidak ada PPN lagi

        return view('customer.cart', compact('cart', 'subtotal', 'total'));
    }

    public function wishlist()
    {
        // UC7: Barang yang disukai (Wajib Login)
        return view('customer.wishlist'); 
    }


    public function checkout(Request $request)
    {
        $selectedItemsData = $request->input('selected_items', []);

        if (empty($selectedItemsData)) {
             return redirect()->route('customer.cart')->with('error', 'Pilih minimal satu barang untuk di-checkout.');
        }

        $selectedIds = collect($selectedItemsData)->pluck('id')->toArray();
        $selectedQtyMap = collect($selectedItemsData)->pluck('qty', 'id')->toArray();

        // Ambil cart user beserta items yang HANYA dipilih saja
        $cart = \App\Models\Cart::with(['items' => function($query) use ($selectedIds) {
            $query->whereIn('id', $selectedIds)->with('product');
        }])->where('user_id', auth()->id())->first();
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang Anda kosong atau barang tidak valid.');
        }

        // Update kuantitas di memori (sebagai preview harga)
        foreach ($cart->items as $item) {
            if (isset($selectedQtyMap[$item->id])) {
                $item->quantity = $selectedQtyMap[$item->id];
                $item->save();
            }
        }

        $subtotal = $cart->items->sum(function($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });

        $total = $subtotal; // Tidak ada PPN lagi

        // Simpan id barang terpilih ke session, agar bisa diambil waktu proses checkout post
        session(['checkout_selected_items' => $selectedIds]);

        return view('customer.checkout', compact('cart', 'subtotal', 'total'));
    }

    public function payment()
    {
        return view('customer.payment'); 
    }

    public function notifications()
    {
        return view('customer.notifications'); 
    }


    // UC3: Kelola Profil
    public function editProfile()
    {
        // Logika untuk menampilkan form edit profil
        // return view('customer.profile.edit', compact('user'));
        return view('customer.profile.edit');
    }

    public function updateProfile(Request $request)
    {
        // Logika untuk menyimpan perubahan profil
        // return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // UC7: Tambah ke Keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = \App\Models\Cart::firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = $cart->items()->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart')->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function addDesignToCart(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'design_json' => 'required|string',
            'preview_image' => 'required|string', // Base64 dataURL
        ]);

        // 1. Simpan gambar preview dari Base64 ke dalam storage (opsional tapi disarankan)
        $imageParts = explode(";base64,", $request->preview_image);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1];
        $imageBase64 = base64_decode($imageParts[1]);
        $fileName = 'designs/design_' . uniqid() . '.' . $imageType;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageBase64);

        // 2. Simpan record Design ke database
        $design = \App\Models\Design::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'design_json' => $request->design_json,
            'preview_image' => $fileName,
            'status' => 'pending'
        ]);

        // 3. Masukkan ke keranjang
        $cart = \App\Models\Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Karena ini desain kustom, kita buat item baru di cart (tidak menggabungkan quantity meski produk sama)
        $cart->items()->create([
            'product_id' => $product->id,
            'design_id' => $design->id,
            'size' => $request->size,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('customer.cart')->with('status', 'Desain kustom Anda berhasil disimpan ke keranjang.');
    }

    public function removeCartItem($id)
    {
        $cartItem = \App\Models\CartItem::where('id', $id)->whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart')->with('status', 'Produk berhasil dihapus dari keranjang.');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $selectedIds = session('checkout_selected_items', []);

        if (empty($selectedIds)) {
             return redirect()->route('customer.cart')->with('error', 'Tidak ada barang yang dipilih untuk proses checkout. Sesi Anda mungkin kedaluwarsa.');
        }

        // Ambil cart hanya dengan produk yang di checkout dari DB memory
        $cart = \App\Models\Cart::with(['items' => function($query) use ($selectedIds) {
            $query->whereIn('id', $selectedIds)->with('product');
        }])->where('user_id', auth()->id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang Anda kosong atau data tidak valid.');
        }

        $subtotal = $cart->items->sum(function($item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });
        
        $totalAmount = $subtotal; // Tidak ada PPN

        // Generate Invoice Number INV-YYYYMMDD-ID
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());

        // Create Order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'invoice_number' => $invoiceNumber,
            'total_amount' => $totalAmount,
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'shipping_address' => $request->recipient_name . " (" . $request->recipient_phone . ") - " . $request->shipping_address,
            'notes' => $request->notes
        ]);

        // Move Cart Items to Order Items
        foreach ($cart->items as $item) {
            if ($item->product) {
                // Determine size. Since the frontend might pass size in $selectedItemsData, let's get it from the map.
                $itemSize = $item->size; // Fallback to cart size
                
                // Cek apakah size di-override saat checkout request
                $selectedItemsData = $request->input('selected_items', []);
                foreach ($selectedItemsData as $selected) {
                    if (isset($selected['id']) && $selected['id'] == $item->id && isset($selected['size'])) {
                        $itemSize = $selected['size'];
                        break;
                    }
                }

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price, // Snapshot harga
                    'size' => $itemSize, // Mengambil size yang benar dari cart item atau request
                    'design_id' => $item->design_id
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }
        }

        // Empty Only Checked Cart Items
        $cart->items()->whereIn('id', $selectedIds)->delete();
        
        // Hapus session
        session()->forget('checkout_selected_items');

        // Hapus cart jika sudah kosong semua
        if ($cart->items()->count() == 0) {
            $cart->delete();
        }

        // --- NOTIFICATION ---
        // Notify all admins about the new order
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\OrderCreatedNotification($order));

        return redirect()->route('customer.orders.show', $order->id)->with('status', 'Pesanan berhasil dibuat! Silakan lanjutkan ke pembayaran.');
    }

    // UC9: Upload Bukti Pembayaran
    public function uploadPaymentProof(Request $request, \App\Models\Order $order)
    {
        // Pastikan order milik user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        // Update or Create Payment record
        $payment = \App\Models\Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'bank_transfer',
                'transaction_id' => $path,
                'payment_status' => 'pending',
                'paid_at' => now(), 
            ]
        );

        // Update Order Status
        $order->update([
            'payment_status' => 'awaiting_verification' // Custom status untuk menunggu cek admin
        ]);

        // --- NOTIFICATION ---
        // Notify all admins that payment proof has been uploaded
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\OrderStatusUpdatedNotification($order, 'Pelanggan telah mengunggah bukti pembayaran untuk pesanan ' . $order->invoice_number . '. Silakan ditinjau.'));


        return redirect()->route('customer.orders.show', $order->id)->with('status', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}