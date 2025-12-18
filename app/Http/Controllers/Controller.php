<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

abstract class Controller
{

public function gallery()
    {
        $path = public_path('images/gallery');
        
        // Gunakan File tanpa backslash di depan jika sudah di-import
        $files = File::exists($path) ? File::files($path) : [];
        
        $images = [];
        foreach ($files as $file) {
            $images[] = asset('images/gallery/' . $file->getFilename());
        }

        return view('dashboard.gallery', compact('images'));
    }

}
