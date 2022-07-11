<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\item;
use App\Models\transaction;
use App\Models\Transaction_detail;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionData extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete'];
    protected $transaction;

    public $search;
    public $total_show = 10;

    public $transaction_id;
    public $cabang;
    public $wa;
    public $name;
    public $order_amount;
    public $produk;
    public $listProduk = [];
    public $listQty = [];
    public $user;

    protected $queryString = ['cabang'];

    protected $rules = [
        'name' => 'required',
        'listProduk' => 'required',
        'listQty' => 'required',
    ];

    protected $rulesUpdate = [
        'name' => 'required',
        'listProduk' => 'required',
        'listQty' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Mohon masukan nama cabang',
        'listProduk.required' => 'Mohon pilih produk transaksi',
        'listQty.required' => 'Mohon masukan jumlah produk transaksi',
    ];

    public function render()
    {
        $this->user = User::find(session()->get('user_id'));
        if ($this->cabang == 'pusat') {
            $this->transaction = transaction::where('cabang_id', 'SMN1000')->where(function ($q) {
                $q->where('transaction_id', 'LIKE', '%'.$this->search.'%')
                ->orWhere('name', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->total_show);
        }
        if ($this->cabang == 'cabang') {
            $this->transaction = transaction::where('cabang_id', '<>', 'SMN1000')->where(function ($q) {
                $q->where('transaction_id', 'LIKE', '%'.$this->search.'%')
                ->orWhere('name', 'LIKE', '%'.$this->search.'%');
            })->paginate($this->total_show);
        }

        $data['transaction'] = $this->transaction;

        // dd($data);
        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.transaction-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
        $this->produk = item::get();
    }

    public function resetInput()
    {
        $this->name = null;
        $this->listProduk = [];
        $this->listQty = [];
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);
        $id = helpers::order_id($this->user->cabang_id);

        $price = 0;

        foreach ($this->listProduk as $i) {
            $priceItem = helpers::price($i);
            Transaction_detail::create([
                'transaction_id' => $id,
                'item_id' => $i,
                'qty' => $this->listQty[$i],
                'price' => $priceItem,
            ]);

            $price += $priceItem;
        }

        $order = transaction::create([
            'transaction_id' => $id,
            'order_amount' => $price,
            'cabang_id' => $this->user->cabang_id,
            'name' => $this->name,
            'wa' => $this->wa,
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil menambah transaksi baru');
    }
}
