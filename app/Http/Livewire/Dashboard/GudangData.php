<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\cabang;
use App\Models\item;
use App\Models\stock;
use Livewire\Component;
use Livewire\WithPagination;

class GudangData extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete'];
    protected $gudang;

    public $search;
    public $total_show = 10;

    public $produk;
    public $cabang;
    public $produk_id;
    public $gudang_id;
    public $cabang_id;
    public $log_id;
    public $qty;

    protected $rules = [
        'cabang_id' => 'required|string',
        'produk_id' => 'required',
        'qty' => 'required',
    ];

    protected $rulesUpdate = [
        'cabang_id' => 'required|string',
        'produk_id' => 'required',
        'qty' => 'required',
    ];

    protected $messages = [
        'cabang_id.required' => 'Mohon pilih cabang gudang',
        'produk_id.required' => 'Mohon pilih produk yang akan ditambah',
        'qty.required' => 'Masukan jumlah produk',
    ];

    public function render()
    {
        $this->gudang = stock::with('cabangs', 'logs', 'items')->whereHas('cabangs', function ($q) {
            $q->where('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('address', 'LIKE', '%'.$this->search.'%');
        })->orWhereHas('items', function ($c) {
            $c->where('name', 'LIKE', '%'.$this->search.'%');
        })->orderBy('cabang_id', 'ASC')->paginate($this->total_show);

        $data['gudang'] = $this->gudang;

        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.gudang-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
        $this->produk = item::get();
        $this->cabang = cabang::get();
    }

    public function resetInput()
    {
        $this->cabang_id = null;
        $this->produk_id = null;
        $this->qty = null;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);

        $check = stock::where(['cabang_id' => $this->cabang_id, 'item_id' => $this->produk_id])->first();
        if ($check) {
            $check->qty += $this->qty;
            $check->save();

            $this->resetInput();
            $this->emit('refresh');

            return session()->flash('success', 'Data produk digudang ini sudah ada, produk berhasil ditambahkan dengan yang baru');
        } else {
            $gudang = stock::create([
                'cabang_id' => $this->cabang_id,
                'item_id' => $this->produk_id,
                'qty' => $this->qty,
            ]);

            $this->resetInput();
            $this->emit('refresh');

            return session()->flash('success', 'Berhasil menambah data cabang baru');
        }
    }

    public function update()
    {
        $this->validate($this->rulesUpdate, $this->messages);
        $cabang = stock::find($this->gudang_id);
        if (!$cabang) {
            return session()->flash('fail', 'Stock Gudang tidak ditemukan');
        }

        $cabang->cabang_id = $this->cabang_id;
        $cabang->item_id = $this->produk_id;
        $cabang->qty = $this->qty;

        $cabang->save();

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil mengubah data stock gudang!');
    }

    public function delete()
    {
        $cabang = stock::find($this->gudang_id);

        if (!$cabang) {
            return session()->flash('fail', 'Stock gudang tidak ditemukan');
        }
        $cabang->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Data stock gudang berhasil dihapus');
    }
}
