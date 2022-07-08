<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                {{ $title }}
            </div>
            <div class="card-toolbar">
                <button type="button" wire:click.prevent="$emit('onClickAdd')"
                    class="btn btn-sm btn-light-success btn-hover-rotate-end" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Tambah Data Stock Gudang">
                    <i class="fas fa-plus-square"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @include('livewire.helper.alert-session')
            <div class="row justify-content-between">
                <div class="mb-4 input-group input-group-outline w-md-25 w-50">
                    <input type="text" class="form-control" placeholder="Search..." wire:model="search">
                </div>

                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-light-success btn-sm" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Refresh Data Karyawan">
                        <i class="fas fa-sync-alt"></i> Segarkan
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="id" class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">No
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Cabang
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Produk
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Jumlah
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($gudang) > 0)
                        @foreach ($gudang as $i => $item)
                        <tr>
                            <td class="align-middle text-center">{{ ($page - 1) * $total_show + $i +1 }}</td>
                            <td class="align-middle text-center text-capitalize">{{ $item->cabangs->name}}</td>
                            <td class="align-middle text-center">{{ $item->items->name}}</td>
                            <td class="align-middle text-center">{{ $item->qty}}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" wire:click.prevent="$emit('onClickUpdate', {{ $item }})"
                                        class="btn btn-sm bg-success text-white btn-hover-rotate-start"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Ubah data {{ $item->name }}"><i
                                            class="fas fa-edit text-light"></i></button>
                                    <button type="button" wire:click.prevent="$emit('onClickDelete', {{ $item->id }})"
                                        class="btn btn-sm bg-danger btn-hover-rotate-end" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Hapus data {{ $item->name }}"><i
                                            class="fas fa-trash text-light"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="no-data">
                            <td>
                                <div class="row justify-content-center">
                                    <img src="{{ asset('assets/images/icon/no_data.png') }}" alt=""
                                        class="h-125px w-125px">
                                    <div class="text-center">
                                        <span class="badge badge-square badge-lg badge-danger text-capitalize p-2">
                                            Tidak ada data gudang</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-end mt-4">
                <div class="col-md-1">
                    @include('livewire.helper.total-show')
                    {{ $gudang->links() }}
                </div>
            </div>
        </div>
    </div>

    <!--Modal Add -->
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_add" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header flex-column justify-content-between">
                    <h5 class="modal-title">Masukan Informasi Stock Gudang</h5>
                    <div class="card shadow-sm bg-light-warning p-2 mt-5 mb-1">
                        <div class="card-body d-flex p-2">
                            <div class="col-1">
                                <span class="badge badge-circle badge-primary"><i class="fas fa-exclamation text-light-warning"></i></span>
                            </div>
                            <span class="text-danger" style="font-size: 10px; font-weight: 600;">Jika gudang cabang sudah memiliki produk yang sama, maka jumlah
                                produk yang di inputkan, akan ditambahkan dengan jumlah produk yang sebelumnya!</span>
                        </div>
                    </div>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form wire:submit.prevent="save" id="form_add">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Cabang Gudang</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example"
                                wire:model="cabang_id">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($cabang as $lc)
                                <option value="{{ $lc->id }}" class="text-capitalize">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                            @error('cabang_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Produk</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example"
                                wire:model="produk_id">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $i)
                                <option value="{{ $i->id }}" class="text-capitalize">{{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('produk_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Jumlah Produk</label>
                            <input type="number" class="form-control form-control-solid" wire:model="qty">
                            @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal Update -->
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_update" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Stock Gudang</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form wire:submit.prevent="update" id="form_update">
                    <input type="hidden" wire:mode="gudang_id">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="cabang" class="required form-label">Stock Gudang</label>
                            <select id="cabang" class="form-select" aria-label="Select example" wire:model="cabang_id">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($cabang as $lc)
                                <option value="{{ $lc->id }}" class="text-capitalize">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                            @error('cabang_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Produk</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example"
                                wire:model="produk_id">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $s)
                                <option value="{{ $s->id }}" class="text-capitalize">{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @error('item_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Jumlah Produk</label>
                            <input type="number" class="form-control form-control-solid" wire:model="qty">
                            @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
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

        Livewire.on('refresh', () => {
            $('#modal_update').modal('hide')
            $('#modal_add').modal('hide')
        })

        Livewire.on('onClickUpdate', (item) => {
            @this.set('gudang_id', item.id)
            @this.set('cabang_id', item.cabang_id)
            @this.set('produk_id', item.item_id)
            @this.set('qty', item.qty)

            $('#modal_update').modal('show')
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
