@extends('dashboard.layouts.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <div class="card-title">
            {{ $title }}
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('post.pengajuan') }}">
            @csrf
            <div class="modal-body">
                @php($user = App\CPU\helpers::getUser(session()->get('token')))
                <input type="hidden" name="cabang_id" value={{ $user->cabang_id }}>
                @php($color = [
                    'success', 'info', 'warning', 'danger'
                    ])
                <div class="mb-10">
                    <label for="hakAkses" class="required form-label">Pilih Produk dan jumlah yang ingin diajukan</label>
                    @foreach ($produk as $key => $i)
                    <div class="d-flex align-items-center mb-8">
                        <!--begin::Bullet-->
                        <span class="bullet bullet-vertical h-40px bg-{{ $color[$key] }}"></span>
                        <!--end::Bullet-->
                        <!--begin::Checkbox-->
                        <div class="form-check form-check-custom form-check-solid mx-5">
                            <input class="form-check-input" id="check{{ $i->id }}" type="checkbox" value="{{ $i->id }}" onclick="active({{ $i->id }})"
                                name="listProduk[]">
                        </div>
                        <!--end::Checkbox-->
                        <!--begin::Description-->
                        <div class="flex-grow-1">
                            <a href="javascript:"
                                class="text-gray-800 text-hover-primary fw-bold fs-6 text-capitalize">{{
                                $i->name }}</a>
                        </div>
                        <!--end::Description-->
                        <div class="flex-grow-1">
                            <div class="input-group input-group-sm justify-content-end">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Qty</span>
                                <input type="number" class="form-control" aria-label="Sizing example input" id="qty{{ $i->id }}"
                                    aria-describedby="inputGroup-sizing-sm" name="listQty[{{ $i->id }}]" style="max-width: 150px;" disabled/>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @error('listProduk')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('js')
    <script>
        function active($id){
            var boxes = $('#' + 'check'+$id).is(":checked");
            if(boxes == true){
                $('#qty'+ $id).removeAttr('disabled');
            }

            if(boxes == false){
                console.log('check', boxes)
                $('#qty'+ $id).attr('disabled', true);
            }
        }
    </script>
@endpush
