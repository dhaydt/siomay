<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\item;
use Livewire\Component;
use Livewire\WithPagination;

class ItemData extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $listeners = ['save', 'update', 'delete'];
    protected $produk;

    public $search;
    public $total_show = 10;

    public $name;
    public $produk_id;
    public $price;
    public $modal;

    protected $rules = [
        'name' => 'required',
        'modal' => 'required',
        'price' => 'required',
    ];

    protected $rulesUpdate = [
        'name' => 'required',
        'modal' => 'required',
        'price' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Mohon masukan nama produk',
        'modal.required' => 'Mohon masukan harga modal produk untuk kalkulasi keuntungan',
        'price.required' => 'Mohon masukan harga jual produk',
    ];

    public function render()
    {
        $this->produk = item::where(function ($q) {
            $q->where('name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('price', 'LIKE', '%'.$this->search.'%');
        })->paginate($this->total_show);

        $data['produk'] = $this->produk;

        $this->dispatchBrowserEvent('contentChange');

        return view('livewire.dashboard.item-data', $data);
    }

    public function mount($title)
    {
        $this->title = $title;
    }

    public function resetInput()
    {
        $this->name = null;
        $this->price = null;
        $this->modal = null;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages);

        $user = item::create([
            'name' => $this->name,
            'price' => $this->price,
            'modal' => $this->modal,
        ]);

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil menambah data produk');
    }

    public function update()
    {
        $this->validate($this->rulesUpdate, $this->messages);
        $user = item::find($this->produk_id);
        if (!$user) {
            return session()->flash('fail', 'Produk tidak ditemukan');
        }

        $user->name = $this->name;
        $user->price = $this->price;
        $user->modal = $this->modal;

        $user->save();

        $this->resetInput();
        $this->emit('refresh');

        return session()->flash('success', 'Berhasil mengubah data produk!');
    }

    public function delete()
    {
        $user = item::find($this->produk_id);

        if (!$user) {
            return session()->flash('fail', 'Produk tidak ditemukan');
        }
        $name = $user->name;

        $user->delete();
        $this->emit('refresh');

        return session()->flash('success', 'Produk '.$name.' Berhasil dihapus');
    }
}
