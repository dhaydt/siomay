<?php

namespace App\Http\Controllers;

class GudangController extends Controller
{
    public function index()
    {
        $data['title'] = 'Stock Gudang';
        $data['active'] = 'Data Stock Gudang';

        return view('dashboard.pages.gudang', $data);
    }

    public function pengajuan_stock()
    {
        $data['title'] = 'Pengajuan Stock Gudang';
        $data['active'] = 'Pengajuan Stock';

        return view('dashboard.pages.stock', $data);
    }
}
