<?php

namespace App\Http\Controllers\Api\Auth;

use App\CPU\helpers;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|string|min:8',
        ], [
            'phone.required' => 'Nomor HP tidak boleh kosong',
            'password.required' => 'Password masih kosong',
            'password.string' => 'Password tidak valid',
            'password.min' => 'Password kurang panjang',
        ]);

        if ($validate->fails()) {
            return helpers::response('error', $validate->errors()->all()[0]);
        }

        $admin = User::where('phone', $request->phone)->first();
        if (!$admin) {
            return helpers::response('error', 'Identitas tidak ditemukan');
        }

        if (!Hash::check($request->password, $admin->password)) {
            return helpers::response('error', 'Password salah');
        }

        $check = LoginLog::where('user_id', $admin->id)->first();
        $token = Crypt::encryptString(now());

        if (isset($check)) {
            $check->user_id = $admin->id;
            $check->token = $token;
            $check->role_id = $admin->role;
            $check->last_login = now();
            $check->status = 1;
            $check->save();

            return helpers::response(1, 'Login Berhasil', [
                'loginLogs' => $check,
                'userData' => $admin,
            ]);
        } else {
            $loginLogs = LoginLog::create([
                'user_id' => $admin->id,
                'token' => $token,
                'role_id' => $admin->role,
                'last_login' => now(),
                'status' => 1,
            ]);

            return helpers::response(1, 'Login Berhasil', [
                'loginLogs' => $loginLogs,
                'userData' => $admin,
            ]);
        }
    }
}
