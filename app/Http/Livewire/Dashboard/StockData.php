<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\cabang;
use App\Models\item;
use App\Models\StockRequest;
use App\Models\StockRequestDetails;
use Livewire\Component;
use Livewire\WithPagination;

class StockData extends Component
{
    public $title;
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete', 'addListProduk'];
    protected $gudang;

    public $search;
    public $total_show = 10;

    public $gudang_id;
    public $cabang_id;
    public $item_id;
    public $produk;
    public $cabang;
    public $qty;
    public $listQty = [];
    public $listProduk = [];

    protected $rules = [
        'cabang_id' => 'required',
        'listProduk' => 'required',
    ];

    protected $rulesUpdate = [
        'cabang_id' => 'required',
        'listProduk' => 'required',
    ];

    protected $messages = [
        'cabang_id.required' => 'Pilih cabang yang ingin mengajukan permintaan!',
        'listProduk.required' => 'Pilih produk yang ingin diajukan!',
    ];

    public function render()
    {
        $this->gudang = StockRequest::with('cabangs', 'requestDetails')->whereHas('cabangs', function ($q) {
            $q->where('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('address', 'LIKE', '%'.$this->search.'%');
        })->orWhereHas('requestDetails', function ($p) {
            $p->whereHas('products', function ($pro) {
                $pro->where('name', 'LIKE', '%'.$this->search.'%');
            });
        })->orWhere('id', 'LIKE', '%'.$this->search.'%')->orderBy('cabang_id', 'ASC')->paginate($this->total_show);

        $data['gudang'] = $this->gudang;

        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.stock-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
        $this->produk = item::get();
        $this->cabang = cabang::where('id', '<>', 'SMN1000')->get();
    }

    public function resetInput()
    {
        $this->cabang_id = null;
        $this->item_id = null;
        $this->qty = null;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);
        $id = helpers::stockRequest($this->cabang_id);

        foreach ($this->listProduk as $val) {
            $detail = StockRequestDetails::create([
                'request_id' => $id,
                'cabang_id' => $this->cabang_id,
                'item_id' => $val,
                'qty' => $this->listQty[$val],
            ]);
        }

        $stock = StockRequest::create([
            'id' => $id,
            'cabang_id' => $this->cabang_id,
            'status' => 'menunggu',
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil menambah data karyawan');
    }
}
