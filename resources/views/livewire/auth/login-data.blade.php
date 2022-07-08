<div class="row">
    <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Silahkan Masukan Identitas anda</h4>
                    <div class="row mt-3">
                        <div class="col-2 text-center ms-auto">
                            <a class="btn btn-link px-3" href="javascript:;">
                                <i class="fa fa-facebook text-white text-lg"></i>
                            </a>
                        </div>
                        <div class="col-2 text-center px-1">
                            <a class="btn btn-link px-3" href="javascript:;">
                                <i class="fa fa-github text-white text-lg"></i>
                            </a>
                        </div>
                        <div class="col-2 text-center me-auto">
                            <a class="btn btn-link px-3" href="javascript:;">
                                <i class="fa fa-google text-white text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="login" method="POST" class="text-start" id="form_login">
                    <div class="input-group input-group-static my-3">
                        <label class="">No. HP</label>
                        <input type="number" class="form-control form-control-solid" wire:model="phone" required>
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="input-group input-group-static mb-3">
                        <label class="">Password</label>
                        <input type="password" class="form-control" wire:model="password" required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                    {{-- <div class="form-check form-switch d-flex align-items-center mb-3">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Ingat Saya</label>
                    </div> --}}
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Login</button>
                    </div>
                </form>
                @include('dashboard.helper.loading', ['message' => 'Sedang melakukan autentikasi'])
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    Livewire.on('response', async (status, message, role) => {
        response = await Swal.fire({
            icon: status,
            title: 'Pemberitahuan',
            text: message,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            timer: 3000
        })
        if(status == 'success' && (response.isDismissed == true || response.isConfirmed == true)){
            if(role == 1 || role == 2){
                location.href = "{{ route('dashboard') }}";
            }
        }
    })
</script>
@endpush
