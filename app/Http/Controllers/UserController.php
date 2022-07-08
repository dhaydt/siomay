<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = '';
        $data['active'] = '';
        $params = $request->status;
        if ($params == 'all') {
            $data['title'] = 'Semua Karyawan';
            $data['active'] = 'Data Karyawan';
        }
        if ($params == 1) {
            $data['title'] = 'Karyawan Administrator';
            $data['active'] = 'Data Administrator';
        }
        if ($params == 2) {
            $data['title'] = 'Karyawan Admin Cabang';
            $data['active'] = 'Data Admin Cabang';
        }
        if ($params == 3) {
            $data['title'] = 'Karyawan Kasir';
            $data['active'] = 'Data Kasir';
        }
        if ($params == 4) {
            $data['title'] = 'Karyawan Gudang';
            $data['active'] = 'Data Gudang';
        }

        return view('dashboard.pages.user', $data);
    }
}
