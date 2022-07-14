@extends('dashboard.layouts.app')
@section('content')
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
                            <label for="" class="required form-label">Menu</label>
                            @foreach ($produk as $key => $i)
                                <div class="d-flex align-items-center mb-8">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-vertical h-40px bg-{{ $color[$key] }}"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Checkbox-->
                                    <div class="form-check form-check-custom form-check-solid mx-5">
                                        <input class="form-check-input" type="checkbox" value="{{ $i->item_id }}" id="check{{ $i->item_id }}" name="listProduk[]" onclick="active({{ $i->item_id }})">
                                    </div>
                                    @php($price= App\CPU\helpers::price($i->item_id))
                                    <input type="hidden" name="price{{ $i->item_id }}" value="{{ $price }}">
                                    <input type="hidden" class="sub" name="sub{{ $i->item_id }}" value="0">
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
                                            <input type="number" class="form-control" onchange="priceCount({{ $i->item_id }})" min="0" max="200" aria-label="Sizing example input" name="listQty[{{ $i->item_id }}]"
                                                aria-describedby="inputGroup-sizing-sm" id="qty{{ $i->item_id }}" style="max-width: 150px;" disabled/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                        <span style="font-size: 24px; font-weight: bold;">Rp. <span id="totalPrice" class="badge badge-success" style="font-size: 24px; font-weight: bold;">0</span></span>
                    </div>
                </div>
            </div>
        </div>
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
                $('#qty'+ $id).attr('disabled', true);
            }
        }

        function priceCount($id){
            var boxes = $('#' + 'check'+$id).is(":checked");
            var total = $('#totalPrice').text();
            var price = $('input[name=price' + $id + ']').val()
            var totalPice = [];
            var sum;
            console.log('val', parseFloat(total), parseFloat(price));
            if(boxes == true){
                $('#qty'+ $id).removeAttr('disabled');
                var qty = $('#qty'+ $id).val();
                sum = parseFloat(qty) * parseFloat(price);
                $('input[name = sub'+$id+']').val(sum);
                var id = $id
                totalPice.push(
                    {[id] : sum}
                )
                console.log('detail', qty + '*'  + price + '+' + total);
            }

            if(boxes == false){
                $('#qty'+ $id).attr('disabled', true);
            }

            var calculate = parseFloat($('.sub').val()) + parseFloat(sum);
            // $.each(totalPice, function( index, value ) {
            //     $.each(value, function(key, val) {
            //         calculate = val + parseFloat(total);
            //     })
            // });
            $('#totalPrice').text(calculate);

            console.log('jumlah', calculate);
        }
    </script>
@endpush
