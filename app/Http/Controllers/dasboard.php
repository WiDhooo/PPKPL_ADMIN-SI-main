<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dasboard extends Controller
{
    public function index()
    {
        return view('dashboard'); // Harus sama dengan nama file di resources/views/
    }
}
