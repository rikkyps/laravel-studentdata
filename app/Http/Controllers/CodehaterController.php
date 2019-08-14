<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodehaterController extends Controller
{
    public function index()
    {
        return 'Anda sedang melihat <strong>Halaman Rahasia.</strong>';
    }
    
    public function secret()
    {
        $url = route('codehater');
        $link = '<a href ="' . $url .'">ERROR 404</a>';
        return $link;
    }
}
