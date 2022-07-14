<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\stock;
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
    public $total = 0;
    public $listProdukPrice;
    public $prices = [];

    public function render()
    {
        return view('livewire.dashboard.kasir-data');
    }

    public function mount($title)
    {
        $this->title = $title;
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
}
