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
                <table id="id" class="table table-hover table-rounded table-striped border gy-7 gs-7 align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">No
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Cabang
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                ID Pengajuan
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center d-flex justify-content-between">
                                <span>Produk</span> <strong>: Jumlah</strong>
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Status
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
                            <td class="align-middle text-center text-capitalize">{{ $item->id}}</td>
                            <td class="align-middle text-center text-capitalize">
                                @foreach ($item->requestDetails as $stok)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge badge-primary">{{ $stok->products->name }}</span>
                                    <strong>: {{ $stok->qty }}</strong>
                                </div>
                            <hr>
                                @endforeach
                            </td>
                            <td class="align-middle text-center"></td>
                            <td class="align-middle text-center text-capitalize">
                                @if ($item->status == "menunggu")
                                    <span class="badge badge-warning">menunggu</span>
                                @elseif($item->status == 'dikirim')
                                    <span class="badge badge-info">dikirim</span>
                                @elseif($item->status == "diterima")
                                    <span class="badge badge-success">diterima</span>
                                @endif
                            </td>
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
                                            Tidak ada data permintaan</span>
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
                    <h5 class="modal-title">Masukan Stock yang ingin ditambahkan</h5>
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
                            <div class="form-check form-check-custom form-check-solid mx-5">
                                <input class="form-check-input" type="checkbox" value="{{ $i->id }}" wire:model="listProduk">
                            </div>
                            <!--end::Checkbox-->
                            <!--begin::Description-->
                            <div class="flex-grow-1">
                                <a href="javascript:" class="text-gray-800 text-hover-primary fw-bold fs-6 text-capitalize">{{ $i->name }}</a>
                            </div>
                            <!--end::Description-->
                            <div class="flex-grow-1">
                                <div class="input-group input-group-sm justify-content-end">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Qty</span>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" wire:model="listQty.{{ $i->id }}" id="{{ $i->id }}" @if(!in_array($i->id,$listProduk)) disabled @endif style="max-width: 150px;"/>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @error('listProduk')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                        {{-- <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Produk</label>
                            @foreach($produk as $i)
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" value="{{ $i->id }}" wire:model="listProduk" class="form-checkbox h-6 w-6 text-green-500">
                                    <span class="ml-3 text-sm">{{ $i->name }}</span>
                                    <input type="number" wire:model="listQty.{{ $i->id }}" id="{{ $i->id }}" @if(!in_array($i->id,$listProduk)) disabled @endif>
                                </label>
                            </div>
                            @endforeach

                        </div> --}}
                        {{-- <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Produk</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example" wire:model="item_id">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $i)
                                <option value="{{ $i->id }}" class="text-capitalize">{{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('item_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
                        {{-- <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Jumlah Produk</label>
                            <input type="number" class="form-control form-control-solid" wire:model="qty">
                            @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
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
                            <select id="hakAkses" class="form-select" aria-label="Select example" wire:model="item_id">
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
    function active($id){
        $('#'+ $id).removeAttr('disabled')
    }
    window.addEventListener('contentChange', event => {

        })

        Livewire.on('onClickAdd', () => {
            $('#modal_add').modal('show')
        })

        Livewire.on('active', (i)=> {

        })

        Livewire.on('refresh', () => {
            $('#modal_update').modal('hide')
            $('#modal_add').modal('hide')
        })

        Livewire.on('onClickUpdate', (item) => {
            @this.set('gudang_id', item.id)
            @this.set('cabang_id', item.cabang_id)
            @this.set('item_id', item.item_id)
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
