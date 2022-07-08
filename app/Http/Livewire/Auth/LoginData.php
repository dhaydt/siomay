<?php

namespace App\Http\Livewire\Auth;

use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class LoginData extends Component
{
    public $listeners = ['login', 'showPassword'];
    public $phone;
    public $password;
    public $showPassword;

    public function render()
    {
        return view('livewire.auth.login-data');
    }

    public function mount()
    {
    }

    protected $rules = [
        'phone' => 'required',
        'password' => 'required|string',
    ];

    protected $messages = [
        'phone.required' => 'Nomor HP diperlukan',
        'password.required' => 'Password tidak boleh kosong',
        'password.string' => 'Password tidak valid',
    ];

    public function login(Request $request)
    {
        $this->validate();
        $user = User::where('phone', $this->phone)->first();
        if (!$user) {
            return $this->emit('response', 'error', 'User tidak ditemukan');
        }

        if (!Hash::check($this->password, $user->password)) {
            return $this->emit('response', 'error', 'Password kamu salah. silahkan masukkan lagi !');
        }

        $token = Crypt::encryptString(now());
        $loginlogs = LoginLog::create([
            'user_id' => $user->id,
            'token' => $token,
            'role_id' => $user->role,
            'status' => 1,
            'last_login' => now(),
            'status' => 1,
        ]);

        session()->put('user_id', $loginlogs->user_id);
        session()->put('token', $loginlogs->token);
        session()->put('role', $user->role);

        return $this->emit('response', 'success', 'Login Sukses', $user->role);
    }

    public function showPassword()
    {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
}
