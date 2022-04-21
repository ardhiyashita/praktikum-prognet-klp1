<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function dashboard(Type $var = null)
    {
        return view('layouts.master');
        
    }

    public function coba(Type $var = null)
    {
        return view('masterCopy');
    }
}
