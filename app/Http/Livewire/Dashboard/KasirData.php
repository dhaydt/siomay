<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\stock;
use App\Models\transaction;
use App\Models\Transaction_detail;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class KasirData extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete', 'onSum', 'updateQty'];
    protected $order;

    public $search;
    public $total_show = 10;

    public $name;
    public $listProduk = [];
    public $listQty = [];
    public $listPrice = [];
    public $produk;
    public $user;
    public $wa;
    public $total = 0;
    public $listProdukPrice;
    public $prices = [];

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
        'name.required' => 'Mohon masukan nama customer',
        'listProduk.required' => 'Mohon pilih menu yang dipesan',
        'listQty.required' => 'Mohon masukan jumlah pesanan',
    ];

    public function render()
    {
        return view('livewire.dashboard.kasir-data');
    }

    public function mount($title)
    {
        $this->title = $title;
        $cabang = helpers::getUser(session()->get('token'))->cabang_id;
        $this->user = User::find(session()->get('user_id'));

        $this->produk = stock::where('cabang_id', $cabang)->get();
        foreach ($this->produk as $item) {
            $this->listQty[$item->item_id] = 0;
        }
    }

    public function resetInput()
    {
        $this->listProduk = [];
        $this->name = null;
        $this->listPrice = [];
        $this->total = 0;

        $cabang = helpers::getUser(session()->get('token'))->cabang_id;
        $this->produk = stock::where('cabang_id', $cabang)->get();
        foreach ($this->produk as $item) {
            $this->listQty[$item->item_id] = 0;
        }
    }

    public function onSum()
    {
        foreach ($this->listQty as $index => $item) {
            $prices = helpers::price($index);
            $this->listProdukPrice[$index] = $item * $prices;
        }

        $this->total = array_sum($this->listProdukPrice);
    }

    public function updateQty($id)
    {
        if (!in_array($id, $this->listProduk)) {
            $this->listQty[$id] = 0;
            $this->onSum();
        }
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);
        $id = helpers::order_id($this->user->cabang_id);

        $totalPrice = 0;

        foreach ($this->listProduk as $i) {
            $priceItem = helpers::price($i);
            $subTotal = floatval($priceItem) * floatval($this->listQty[$i]);
            Transaction_detail::create([
                'transaction_id' => $id,
                'item_id' => $i,
                'qty' => $this->listQty[$i],
                'price' => $priceItem,
                'sub_total' => $subTotal,
            ]);

            helpers::kurangStock($this->user->cabang_id, $i, $this->listQty[$i]);

            $totalPrice += $subTotal;
        }

        $order = transaction::create([
            'transaction_id' => $id,
            'order_amount' => $totalPrice,
            'cabang_id' => $this->user->cabang_id,
            'name' => $this->name,
            'wa' => $this->wa,
            'user_id' => $this->user->id,
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Transaksi berhasil disimpan!');
    }
}
