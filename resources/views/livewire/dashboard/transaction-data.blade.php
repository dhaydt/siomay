<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                {{ $title }}
            </div>
            <div class="card-toolbar">
                <button type="button" wire:click.prevent="$emit('onClickAdd')"
                    class="btn btn-sm btn-light-success btn-hover-rotate-end" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Tambah Transaksi Baru">
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
                <table id="id"
                    class="table table-hover table-rounded table-striped border gy-7 gs-7 align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">No
                            </th>
                            @if (session()->get('role') == 1)
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Cabang
                            </th>
                            @endif
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">Nama
                            </th>
                            <th
                                class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center d-flex justify-content-between">
                                <span>Rincian belanja</span> <strong>: Jumlah</strong>
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Total belanja
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Kasir
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($transaction) > 0)
                        @foreach ($transaction as $i => $item)
                        <tr>
                            <td class="align-middle text-center">{{ ($page - 1) * $total_show + $i +1 }}</td>
                            @if (session()->get('role') == 1)
                            <td class="align-middle text-center">{{ $item->cabangs->name}}</td>
                            @endif
                            <td class="align-middle text-center text-capitalize">{{ $item->name}}</td>
                            <td class="align-middle text-center">
                                @foreach ($item->details as $stok)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge badge-primary">{{ $stok->products->name }}</span>
                                    <strong>: {{ $stok->qty }}</strong>
                                </div>
                                <hr>
                                @endforeach
                            </td>
                            <td class="align-middle text-center">{{ App\CPU\helpers::currency($item->order_amount)}}
                            <td class="align-middle text-center text-capitalize">
                                @if ($item->user)
                                    {{ $item->user->name}}
                                @else
                                    <span class="badge badge-danger">Data kasir tidak ditemukan</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- <button type="button" wire:click.prevent="$emit('onClickUpdate', {{ $item }})"
                                        class="btn btn-sm bg-success text-white btn-hover-rotate-start"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Ubah data {{ $item->name }}"><i
                                            class="fas fa-edit text-light"></i></button> --}}
                                    <button type="button"
                                        wire:click.prevent="$emit('onClickDelete', `{{ $item->transaction_id }}`)"
                                        class="btn btn-sm bg-danger btn-hover-rotate-end" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Hapus data transaksi"><i
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
                                            Tidak ada data cabang</span>
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
                    {{ $transaction->links() }}
                </div>
            </div>
        </div>
    </div>

    <!--Modal Add -->
    <div wire:ignore.self class="modal fade" tabindex="-1" id="modal_add" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Informasi Transaksi</h5>

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
                            <label for="exampleFormControlInput1" class="required form-label">Nama</label>
                            <input type="text" class="form-control form-control-solid" wire:model="name"
                                placeholder="Masukan nama pelanggan" />
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
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
                                        <input class="form-check-input" type="checkbox" value="{{ $i->item_id }}"
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
                                                @if(!in_array($i->item_id, $listProduk)) disabled @endif
                                            style="max-width: 150px;"/>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @error('listQty')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="total d-none">
                            <h5 class=" d-flex justify-content-between">Total belanja : <span id="total" class="badge badge-success bg-success fs-6">Rp. 20000</span></h5>
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
                    <h5 class="modal-title">Ubah Data Cabang</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form wire:submit.prevent="update" id="form_update">
                    <input type="hidden" wire:mode="transaction_id">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Nama</label>
                            <input type="text" class="form-control form-control-solid" wire:model="name"
                                placeholder="Masukan nama karyawan" />
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="email" class="form-label">Alamat Cabang</label>
                            <textarea id="email" class="form-control form-control-solid"
                                wire:model="address"></textarea>
                            @error('address')
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
            @this.set('transaction_id', item.id)
            @this.set('name', item.name)

            $('#modal_update').modal('show')
        })

        Livewire.on('onClickDelete', async (id) => {
            console.log('id', id)
            const response = await alertHapus('Warning !!!', 'Anda yakin ingin menghapus data cabang ini?')
            if(response.isConfirmed == true){
                @this.set('transaction_id', id)
                Livewire.emit('delete')
            }
        })
</script>
@endpush
