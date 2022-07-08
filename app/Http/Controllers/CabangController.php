<?php

namespace App\Http\Controllers;

class CabangController extends Controller
{
    public function index()
    {
        $data['title'] = 'Cabang Penjualan';
        $data['active'] = 'Data Cabang';

        return view('dashboard.pages.cabang', $data);
    }
}
