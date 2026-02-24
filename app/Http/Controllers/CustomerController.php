<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function design()
    {
        return view('customer.design'); // Arahkan ke file design.blade.php
    }

    public function orders()
    {
        // Nanti di sini kita tarik data order dari DB
        return view('customer.orders'); 
    }

    public function invoices()
    {
        return view('customer.invoices');
    }

    public function returns()
    {
        return view('customer.returns');
    }


    // ... fungsi design, orders, invoices, returns yang sudah ada ...

    public function cart()
    {
      
        
        return view('customer.cart');
    }

    public function wishlist()
    {
        
        return view('customer.wishlist'); 
    }

}