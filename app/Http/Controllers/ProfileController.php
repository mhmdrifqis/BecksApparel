<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Address;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil dan alamat.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Mengambil alamat default atau alamat pertama yang ditemukan
        $address = Address::where('user_id', $user->id)
            ->orderBy('is_default', 'desc') // Prioritaskan yang default
            ->first();

        return view('customer.profile', compact('user', 'address'));
    }

    /**
     * Memperbarui profil pengguna dan alamat pengiriman.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            // Validasi User
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:8'],

            // Validasi Alamat
            'recipient_name' => ['required', 'string', 'max:255'],
            'address_phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'full_address' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($request, $user) {
            // 1. Update Data User
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // 2. Update atau Buat Alamat
            Address::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'recipient_name' => $request->recipient_name,
                    'phone' => $request->address_phone,
                    'province' => $request->province,
                    'city' => $request->city,
                    'district' => $request->district,
                    'postal_code' => $request->postal_code,
                    'full_address' => $request->full_address,
                    'is_default' => true,
                ]
            );
        });

        return back()->with('status', 'Profil dan alamat berhasil diperbarui!');
    }
}