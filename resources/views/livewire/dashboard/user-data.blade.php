<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                {{ $title }}
            </div>
            <div class="card-toolbar">
                <button type="button" wire:click.prevent="$emit('onClickAdd')"
                    class="btn btn-sm btn-light-success btn-hover-rotate-end" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Tambah Karyawan">
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
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">Nama
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">No HP
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">Email
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">Cabang
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">Hak
                                Akses
                            </th>
                            <th class="text-uppercase text-sm text-dark font-weight-bolder opacity-75 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($user) > 0)
                        @foreach ($user as $i => $item)
                        <tr>
                            <td class="align-middle text-center">{{ ($page - 1) * $total_show + $i +1 }}</td>
                            <td class="align-middle text-center text-capitalize">{{ $item->name}}</td>
                            <td class="align-middle text-center">{{ $item->phone}}</td>
                            <td class="align-middle text-center">{{ $item->email}}</td>
                            <td class="align-middle text-center text-capitalize">{{ $item->cabangs->name}}</td>
                            <td class="align-middle text-center text-capitalize">{{ $item->roles->role}}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" wire:click.prevent="$emit('onClickUpdate', {{ $item }})"
                                        class="btn btn-sm bg-success text-white btn-hover-rotate-start"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah data {{ $item->name }}"><i
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
                                            Tidak ada data karyawan</span>
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
                    {{ $user->links() }}
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
                    <h5 class="modal-title">Masukan Informasi Karyawan</h5>

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
                            <label for="hakAkses" class="required form-label">Cabang Penempatan Karyawan</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example" wire:model="cabang_id">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($listCabang as $lc)
                                    <option value="{{ $lc->id }}" class="text-capitalize">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                            @error('cabang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Nama</label>
                            <input type="text" class="form-control form-control-solid" wire:model="name"
                                placeholder="Masukan nama karyawan" />
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control form-control-solid" wire:model="email"
                                placeholder="Masukan email karyawan" />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="mb-10">
                            <label for="phone" class="required form-label">Nomor Handphone </label>
                            <input type="number" id="phone" class="form-control form-control-solid" wire:model="phone"
                                placeholder="081122334455" />
                                <div class="text-danger mt-2" style="font-size: 10px;">Nb: digunakan sebagai ID saat login</div>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Hak Akses</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example" wire:model="role">
                                <option value="">-- Pilih Hak Akses --</option>
                                <option value="1">Administrator / Super Admin</option>
                                <option value="2">Admin</option>
                                <option value="3">Kasir</option>
                                <option value="4">Gudang</option>
                            </select>
                            @error('role')
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
                    <h5 class="modal-title">Ubah Karyawan Data</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form wire:submit.prevent="update" id="form_update">
                    <input type="hidden" wire:mode="user_id">
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="cabang" class="required form-label">Cabang Penempatan Karyawan</label>
                            <select id="cabang" class="form-select" aria-label="Select example" wire:model="cabang_id">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach ($listCabang as $lc)
                                    <option value="{{ $lc->id }}" class="text-capitalize">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                            @error('cabang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Nama</label>
                            <input type="text" class="form-control form-control-solid" wire:model="name"
                                placeholder="Masukan nama karyawan" />
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control form-control-solid" wire:model="email"
                                placeholder="Masukan email karyawan" />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="mb-10">
                            <label for="phone" class="required form-label">Nomor Handphone </label>
                            <input type="number" id="phone" class="form-control form-control-solid" wire:model="phone"
                                placeholder="081122334455" />
                                <div class="text-danger mt-2" style="font-size: 10px;">Nb: digunakan sebagai ID saat login</div>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="mb-10">
                            <label for="hakAkses" class="required form-label">Hak Akses</label>
                            <select id="hakAkses" class="form-select" aria-label="Select example" wire:model="role">
                                <option value="">-- Pilih Hak Akses --</option>
                                <option value="1">Administrator / Super Admin</option>
                                <option value="2">Admin</option>
                                <option value="3">Kasir</option>
                                <option value="4">Gudang</option>
                            </select>
                            @error('role')
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
            @this.set('user_id', item.id)
            @this.set('cabang_id', item.cabang_id)
            @this.set('name', item.name)
            @this.set('phone', item.phone)
            @this.set('role', item.role)
            @this.set('email', item.email)

            $('#modal_update').modal('show')
        })

        Livewire.on('onClickDelete', async (id) => {
            const response = await alertHapus('Warning !!!', 'Anda yakin ingin menghapus data ini?')
            if(response.isConfirmed == true){
                @this.set('user_id', id)
                Livewire.emit('delete')
            }
        })
</script>
@endpush
