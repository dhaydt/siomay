<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\cabang;
use Livewire\Component;
use Livewire\WithPagination;

class CabangData extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete'];
    protected $cabang;

    public $search;
    public $total_show = 10;

    public $cabang_id;
    public $name;
    public $address;

    protected $rules = [
        'name' => 'required',
        'cabang_id' => 'required',
        'address' => 'required',
    ];

    protected $rulesUpdate = [
        'name' => 'required',
        'cabang_id' => 'required',
        'address' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Mohon masukan nama cabang',
        'cabang_id.required' => 'Pilih cabang yang melakukan pengajuan',
        'address.required' => 'Mohon masukan alamat cabang',
    ];

    public function render()
    {
        $this->cabang = cabang::where(function ($q) {
            $q->where('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('address', 'LIKE', '%'.$this->search.'%');
        })->paginate($this->total_show);

        $data['cabang'] = $this->cabang;
        dd($data);

        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.cabang-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
    }

    public function resetInput()
    {
        $this->name = null;
        $this->address = null;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);
        $id = helpers::cabangId();

        $user = cabang::create([
            'id' => $id,
            'name' => $this->name,
            'address' => $this->address,
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil menambah data cabang baru');
    }

    public function update()
    {
        $this->validate($this->rulesUpdate, $this->messages);
        $cabang = cabang::find($this->cabang_id);
        if (!$cabang) {
            return session()->flash('fail', 'Cabang tidak ditemukan');
        }

        $cabang->name = $this->name;
        $cabang->address = $this->address;

        $cabang->save();

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil mengubah data karyawan!');
    }

    public function delete()
    {
        $cabang = cabang::find($this->cabang_id);

        if (!$cabang) {
            return session()->flash('fail', 'Cabang tidak ditemukan');
        }
        $name = $cabang->name;

        $cabang->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Cabang '.$name.' Berhasil dihapus');
    }
}
