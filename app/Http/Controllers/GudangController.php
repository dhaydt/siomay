<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->status;
        if ($params == 'pusat') {
            $data['title'] = 'Stock Gudang Pusat';
            $data['active'] = 'Data Stock Gudang Pusat';
        } else {
            $data['title'] = 'Stock Gudang';
            $data['active'] = 'Data Stock Gudang Cabang';
        }

        return view('dashboard.pages.gudang', $data);
    }

    public function pengajuan_stock(Request $request)
    {
        $params = $request->status;
        if ($params == 'menunggu') {
            $data['title'] = 'Pengajuan Stock Gudang Baru';
            $data['active'] = 'Pengajuan Stock Baru';
        } elseif ($params == 'dikirim') {
            $data['title'] = 'Pengajuan Stock Gudang Dikirim';
            $data['active'] = 'Pengajuan Stock Dikirim';
        } elseif ($params == 'diterima') {
            $data['title'] = 'Pengajuan Stock Gudang Diterima';
            $data['active'] = 'Pengajuan Stock Diterima';
        }

        return view('dashboard.pages.stock', $data);
    }
}
