<?php

namespace App\Http\Controllers;

class ItemController extends Controller
{
    public function index()
    {
        $data['title'] = 'Produk Item';
        $data['active'] = 'Data Produk';

        return view('dashboard.pages.item', $data);
    }
}
