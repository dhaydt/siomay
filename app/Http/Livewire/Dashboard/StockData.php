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
    public $statusBarang;
    public $cabang;
    public $qty;
    public $listQty = [];
    public $listProduk = [];
    public $status;

    protected $queryString = ['status'];

    protected $rules = [
        'cabang_id' => 'required',
        'listProduk' => 'required',
    ];

    protected $rulesUpdate = [
        'cabang_id' => 'required',
        'listProduk' => 'required',
        'statusBarang' => 'required',
    ];

    protected $messages = [
        'cabang_id.required' => 'Pilih cabang yang ingin mengajukan permintaan!',
        'listProduk.required' => 'Pilih produk yang ingin diajukan!',
        'statusBarang.required' => 'Pilih status pengajuan!',
    ];

    public function render()
    {
        if ($this->status == 'menunggu') {
            $this->gudang = StockRequest::with('cabangs', 'requestDetails')->where('status', 'menunggu')->whereHas('cabangs', function ($q) {
                $q->where('name', 'LIKE', '%'.$this->search.'%')
                            ->orWhere('address', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->total_show);
        } elseif ($this->status == 'dikirim') {
            $this->gudang = StockRequest::with('cabangs', 'requestDetails')->where('status', 'dikirim')->whereHas('cabangs', function ($q) {
                $q->where('name', 'LIKE', '%'.$this->search.'%')
                            ->orWhere('address', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->total_show);
        } elseif ($this->status == 'diterima') {
            $this->gudang = StockRequest::with('cabangs', 'requestDetails')->where('status', 'diterima')->whereHas('cabangs', function ($q) {
                $q->where('name', 'LIKE', '%'.$this->search.'%')
                            ->orWhere('address', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->total_show);
        }

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

    public function update()
    {
        $this->validate($this->rulesUpdate, $this->messages);
        $gudang = StockRequest::find($this->gudang_id);
        if (!$gudang) {
            return session()->flash('fail', 'Data permintaan tidak ditemukan');
        }

        $gudang->cabang_id = $this->cabang_id;
        $gudang->status = $this->statusBarang;
        $gudang->save();

        $details = StockRequestDetails::where('request_id', $gudang->id)->get();

        $exist = [];

        foreach ($details as $de) {
            array_push($exist, $de->item_id);
            foreach ($this->listProduk as $produk) {
                if ($produk == $de->item_id) {
                    $de->qty = $this->listQty[$produk];
                    $de->save();
                }
            }

            if (in_array($de->item_id, $this->listProduk)) {
            } else {
                $de->delete();
            }
        }

        foreach ($this->listQty as $key => $val) {
            if (in_array($key, $exist)) {
            } else {
                StockRequestDetails::create([
                    'request_id' => $this->gudang_id,
                    'cabang_id' => $this->cabang_id,
                    'item_id' => $key,
                    'qty' => $val,
                ]);
            }
        }

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil mengubah data permintaan!');
    }

    public function delete()
    {
        $user = StockRequest::find($this->gudang_id);

        if (!$user) {
            return session()->flash('fail', 'Permintaan tidak ditemukan');
        }

        $detail = StockRequestDetails::where('request_id', $user->id)->get();
        foreach ($detail as $d) {
            $d->delete();
        }

        $user->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Permintaan berhasil dihapus');
    }
}
