<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Landing Page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Simulasi data dari Database
        // Nanti bisa diganti dengan: Product::all();
        $products = [
            [
                'id' => 1,
                'name' => 'Thunder Bolt Kit',
                'category' => 'Futsal',
                'price' => '125.000',
                'image' => 'https://i.pinimg.com/736x/c1/d1/b3/c1d1b3c50711f3d3e5c65dfee53bf4f8.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Chicago Style Pro',
                'category' => 'Basket',
                'price' => '150.000',
                'image' => 'https://i.pinimg.com/736x/c6/2a/43/c62a436b98376032f54601ad58ff0480.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Training Polo Official',
                'category' => 'Casual',
                'price' => '95.000',
                'image' => 'https://i.pinimg.com/736x/26/8a/ce/268ace971d5cfa396f4e1a585e11ebaf.jpg'
            ],
            [
                'id' => 4,
                'name' => 'E-Sport Dragon Elite',
                'category' => 'E-Sport',
                'price' => '180.000',
                'image' => 'https://i.pinimg.com/1200x/03/dd/11/03dd11955d0849cf6c11def097c8812d.jpg'
            ],
            [
                'id' => 5,
                'name' => 'Goalkeeper Shield',
                'category' => 'Soccer',
                'price' => '135.000',
                'image' => 'https://i.pinimg.com/1200x/cd/a8/5f/cda85f0aa49157dc909f8408682c355a.jpg'
            ],
            [
                'id' => 6,
                'name' => 'Running Vest Light',
                'category' => 'Athletic',
                'price' => '85.000',
                'image' => 'https://i.pinimg.com/1200x/df/d5/b3/dfd5b3f600bb49187f7a8a2ce85bc02f.jpg'
            ]
        ];

        // Mengirim data $products ke view 'welcome'
        return view('welcome', compact('products'));
    }
}
