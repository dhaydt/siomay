<?php

namespace App\CPU;

use App\Models\cabang;
use App\Models\item;
use App\Models\LoginLog;
use App\Models\stock;
use App\Models\StockRequest;
use App\Models\transaction;
use App\Models\User;
use App\Models\WebConfig;
use Carbon\Carbon;

class helpers
{
    public static function kurangStock($cabang_id, $item_id, $qty)
    {
        $stock = stock::where(['cabang_id' => $cabang_id, 'item_id' => $item_id])->first();
        $stock->qty = floatval($stock->qty) - $qty;
        $stock->save();
    }

    public static function cabangId()
    {
        $cabang_id = 'SMN'.(1000 + cabang::all()->count() + 1);

        return $cabang_id;
    }

    public static function price($id)
    {
        $item = item::find($id);

        return $item->price;
    }

    public static function stockRequest($cabang_id)
    {
        $number = StockRequest::whereDate('created_at', Carbon::today())->count() + 1;
        $request = $number.'/'.Carbon::today()->format('d.m.Y').'/'.$cabang_id.'/'.(100 + StockRequest::all()->count() + 1);

        return $request;
    }

    public static function order_id($cabang_id)
    {
        $number = transaction::whereDate('created_at', Carbon::today())->count() + 1;
        $request = $number.'/'.Carbon::today()->format('d.m.Y').'/'.$cabang_id.'/'.(100 + transaction::all()->count() + 1);

        return $request;
    }

    public static function currency($val)
    {
        $price = 'Rp '.number_format($val);

        return $price;
    }

    public static function response($status, $message = null, $data = [], $error_code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'error_code' => $error_code,
        ]);
    }

    public static function config($name)
    {
        $response = '[]';
        $config = WebConfig::where('name', $name);
        if ($config) {
            $response = $config;

            return $response;
        }

        return $response;
    }

    public static function getSetting($object, $name)
    {
        $config = null;
        foreach ($object as $set) {
            if ($set['name'] == $name) {
                $config = $set['value'];
            }
        }

        return $config;
    }

    public static function getUser($token)
    {
        $token = LoginLog::where('token', $token)->first();
        $user = User::with('roles')->find($token->user_id);
        if ($user) {
            return $user;
        }

        return 0;
    }
}
