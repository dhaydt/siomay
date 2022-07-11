<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->cabang;
        if ($params == 'pusat') {
            $data['title'] = 'Transaksi Pusat';
            $data['active'] = 'Data Transaksi Pusat';
        }

        if ($params == 'cabang') {
            $data['title'] = 'Transaksi Cabang';
            $data['active'] = 'Data Transaksi Cabang';
        }

        return view('dashboard.pages.transaction', $data);
    }
}
