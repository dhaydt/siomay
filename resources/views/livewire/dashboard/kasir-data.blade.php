<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                {{ $title }}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="card-title">
                                Menu pesanan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Atas Nama</label>
                                <input type="text" class="form-control form-control-solid" name="name"
                                    placeholder="Masukan nama pelanggan" />
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @php
                            $color = [
                            'success', 'info', 'warning', 'danger'
                            ];
                            @endphp
                            <div class="mb-10">
                                <label for="hakAkses" class="required form-label">Produk</label>
                                @foreach ($produk as $key => $i)
                                <div class="d-flex align-items-center mb-8">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-vertical h-40px bg-{{ $color[$key] }}"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Checkbox-->
                                    @php($basePrice = App\CPU\helpers::price($i->item_id))
                                    <input type="hidden" value="{{ $basePrice }}" name="">
                                    <div class="form-check form-check-custom form-check-solid mx-5">
                                        <input class="form-check-input" type="checkbox" value="{{ $i->item_id }}" wire:change="updateQty({{ $i->item_id }})"
                                            wire:model="listProduk">
                                    </div>
                                    <!--end::Checkbox-->
                                    <!--begin::Description-->
                                    <div class="flex-grow-1">
                                        <a href="javascript:"
                                            class="text-gray-800 text-hover-primary fw-bold fs-6 text-capitalize">{{
                                            $i->items->name }}</a>
                                    </div>
                                    <!--end::Description-->
                                    <div class="flex-grow-1">
                                        <div class="input-group input-group-sm justify-content-end">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Qty</span>
                                            <input type="number" class="form-control" aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-sm"
                                                wire:model="listQty.{{ $i->item_id }}" id="{{ $i->item_id }}"
                                                {{-- wire:change="$emit('onSum', {{ $i }}, {{ $i->item_id }})" --}}
                                                wire:change="onSum"
                                                @if(!in_array($i->item_id,$listProduk)) disabled @endif
                                            style="max-width: 150px;"/>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @error('listProduk')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <div class="card-title">
                                Total belanja
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-end">
                            <span style="font-size: 24px; font-weight: bold;">Rp. <span id="totalPrice"
                                    class="badge badge-success" style="font-size: 24px; font-weight: bold;">{{ $total }}</span></span>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 shadow-md" style="margin-top: 45%">
                        Bayar
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    window.addEventListener('contentChange', event => {

})

Livewire.on('onClickAdd', () => {
    $('#modal_add').modal('show')
})

Livewire.on('active', (i)=> {

})


// Livewire.on('onSum', (item, id) => {
//     console.log('sum', item.items.price, @this.listQty)
// })

Livewire.on('refresh', () => {
    $('#modal_update').modal('hide')
    $('#modal_add').modal('hide')
    $('#modal_change').modal('hide')
})

Livewire.on('onClickUpdate', (item) => {
    @this.set('gudang_id', item.id)
    @this.set('cabang_id', item.cabang_id)
    @this.set('item_id', item.item_id)
    @this.set('statusBarang', item.status)
    var request = item.request_details
    var items = [];
    request.forEach((rd)=> {
        items.push(rd.item_id)
        @this.set('listQty.'+rd.item_id, rd.qty)
    } )
    @this.set('listProduk', items);
    console.log('for', item)

    $('#modal_update').modal('show')
})

Livewire.on('onClickChange', (item) => {
    @this.set('gudang_id', item.id)
    @this.set('statusBarang', item.status)

    $('#modal_change').modal('show')
})

Livewire.on('onClickDelete', async (id) => {
    const response = await alertHapus('Warning !!!', 'Anda yakin ingin menghapus data ini?')
    if(response.isConfirmed == true){
        @this.set('gudang_id', id)
        Livewire.emit('delete')
    }
})
</script>
@endpush
