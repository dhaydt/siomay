<?php

namespace App\Http\Controllers;

use App\CPU\helpers;
use App\Models\item;
use App\Models\StockRequest;
use App\Models\StockRequestDetails;
use Brian2694\Toastr\Facades\Toastr;
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

    public function form_pengajuan_stock()
    {
        $data['title'] = 'Pengajuan Penambahan Stock Gudang';
        $data['active'] = 'Pengajuan Stock Gudang';
        $data['produk'] = item::get();

        return view('dashboard.pages.form_pengajuan', $data);
    }

    public function post_form_pengajuan_stock(Request $request)
    {
        if ($request->cabang_id == 'SMN1000') {
            Toastr::warning('Administrator / Admin Pusat tidak bisa mengajukan pengajuan stock gudang!');

            return redirect()->back();
        }
        if (!$request->listProduk) {
            Toastr::warning('Mohon pilih produk yang ingin diajukan!');

            return redirect()->back();
        }

        foreach ($request->listQty as $key => $l) {
            if ($l == null) {
                Toastr::warning('Mohon masukan jumlah produk yang dibutuhkan!');

                return redirect()->back();
            } else {
                $id = helpers::stockRequest($request->cabang_id);
                foreach ($request->listProduk as $val) {
                    StockRequestDetails::create([
                        'request_id' => $id,
                        'cabang_id' => $request->cabang_id,
                        'item_id' => $val,
                        'qty' => $request->listQty[$val],
                    ]);
                }

                StockRequest::create([
                    'id' => $id,
                    'cabang_id' => $request->cabang_id,
                    'status' => 'menunggu',
                ]);

                Toastr::success('Berhasil mengajukan permintaan stock gudang!');

                return redirect()->back();
            }
        }
    }
}
