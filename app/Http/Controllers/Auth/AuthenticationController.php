<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.Login');
    }

    public function logout(Request $request)
    {
        $loginLogs = LoginLog::where('token', $request->session()->get('token'))
        ->where('user_id', $request->session()->get('user_id'))
        ->where('status', 1)->first();
        $loginLogs->status = 0;
        $loginLogs->save();
        $request->session()->forget('token');
        $request->session()->forget('user_id');
        $request->session()->forget('role');

        return redirect()->route('login')->with('success', 'Logout Berhasil');
    }
}
