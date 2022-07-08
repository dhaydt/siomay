<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\cabang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserData extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete'];
    protected $user;

    public $search;
    public $total_show = 10;

    public $user_id;
    public $cabang_id;
    public $name;
    public $phone;
    public $email;
    public $role;
    public $title;
    public $status;
    public $listCabang;
    public $password;

    public $cabang;

    protected $queryString = ['status', 'cabang'];

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required',
        'role' => 'required',
    ];

    protected $rulesUpdate = [
        'name' => 'required|string',
        'phone' => 'required',
        'role' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Mohon masukan nama',
        'phone.required' => 'Nomor handphone diperlukan untuk identitas login',
        'role.required' => 'Mohon pilih Hak akses Karyawan',
    ];

    public function render()
    {
        if ($this->status == 'all') {
            $this->user = User::with('roles', 'cabangs')->where(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('cabangs', function ($c) {
                        $c->where('name', 'LIKE', '%'.$this->search.'%');
                    });
            })->paginate($this->total_show);
            $data['user'] = $this->user;
        } else {
            $this->user = User::with('roles', 'cabangs')->where('role', $this->status)->where(function ($q) {
                $q->where('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('cabangs', function ($c) {
                        $c->where('name', 'LIKE', '%'.$this->search.'%');
                    });
            })->paginate($this->total_show);

            $data['user'] = $this->user;
            // dd($data);
        }
        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.user-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
        $this->listCabang = cabang::get();
    }

    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->role = null;
        $this->password = null;
        $this->confirm_password = null;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);
        $user = User::where('phone', $this->phone)->first();

        if ($user) {
            return session()->flash('fail', 'Nomor Handphone sudah digunakan di akun lain!');
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'cabang_id' => $this->cabang_id,
            'password' => Hash::make(env('PASSWORD_USER')),
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil menambah data karyawan');
    }

    public function update()
    {
        $this->validate($this->rulesUpdate, $this->messages);
        $user = User::find($this->user_id);
        if (!$user) {
            return session()->flash('fail', 'Karyawan tidak ditemukan');
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->role = $this->role;
        $user->cabang_id = $this->cabang_id;
        if ($this->password !== null) {
            if ($this->password && ($this->password == $this->confirm_password)) {
                $user->password = Hash::make($this->password);
            } else {
                return session()->flash('fail', 'Password tidak sama');
            }
        }

        $user->save();

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil mengubah data karyawan!');
    }

    public function delete()
    {
        $user = User::find($this->user_id);

        if (!$user) {
            return session()->flash('fail', 'Karyawan tidak ditemukan');
        }
        $name = $user->name;

        $user->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Karyawan '.$name.' Berhasil dihapus');
    }
}
