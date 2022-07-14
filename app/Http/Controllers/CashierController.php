<?php

namespace App\Http\Controllers;

use App\CPU\helpers;
use App\Models\stock;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Kasir Siomay Mas Nur';
        $data['active'] = 'Kasir Dashboard';

        $cabang = helpers::getUser(session()->get('token'))->cabang_id;

        $data['produk'] = stock::where('cabang_id', $cabang)->get();

        return view('dashboard.pages.kasir', $data);
    }
}
