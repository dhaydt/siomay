<?php

namespace App\Http\Livewire\Dashboard;

use App\CPU\helpers;
use App\Models\stock;
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
    public $prices = [];
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
        if ($this->cabang == 'pusat') {
            $this->transaction = transaction::with('details', 'user')->where('cabang_id', 'SMN1000')->where(function ($q) {
                $q->where('transaction_id', 'LIKE', '%'.$this->search.'%')
                ->orWhere('name', 'LIKE', '%'.$this->search.'%')
                ->orWhereHas('user', function ($u) {
                    $u->where('name', 'LIKE', '%'.$this->search.'%');
                });
            })->orderBy('created_at', 'desc')->paginate($this->total_show);
        }
        if ($this->cabang == 'cabang') {
            if (session()->get('role') == 1) {
                $this->transaction = transaction::with('details', 'user')->where('cabang_id', '<>', 'SMN1000')->where(function ($q) {
                    $q->where('transaction_id', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'LIKE', '%'.$this->search.'%');
                    });
                })->orderBy('created_at', 'desc')->paginate($this->total_show);
            } elseif (session()->get('role') == 2) {
                $this->transaction = transaction::with('details', 'user')->where('cabang_id', $this->user->cabang_id)->where(function ($q) {
                    $q->where('transaction_id', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('name', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'LIKE', '%'.$this->search.'%');
                    });
                })->orderBy('created_at', 'desc')->paginate($this->total_show);
            }
        }

        $data['transaction'] = $this->transaction;

        // dd($data);
        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.transaction-data', $data);
    }

    public function mount($title)
    {
        $this->user = User::find(session()->get('user_id'));
        // dd($this->user);
        $this->title = $title;
        $this->produk = stock::with('items')->where('cabang_id', $this->user->cabang_id)->get();
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

        // $price = 0;
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

        return session()->flash('success', 'Berhasil menambah transaksi baru');
    }

    public function delete()
    {
        $user = transaction::where('transaction_id', $this->transaction_id)->first();

        if (!$user) {
            return session()->flash('fail', 'Transaksi tidak ditemukan');
        }

        $detail = Transaction_detail::where('transaction_id', $this->transaction_id)->get();
        foreach ($detail as $d) {
            $d->delete();
        }

        $user->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Data transaksi berhasil dihapus');
    }
}
