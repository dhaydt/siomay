@push('css')
<style>
    #preview {
        height: 100px;
    }

    .preview-img{
        height: 100px;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.6em + 1.21875rem);
        margin: 0;
        opacity: 0;
        cursor: pointer;
    }

    .footer-img {
        position: relative;
    }

    label::before,
    .custom-file-label {
        transition: background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition-property: background-color, border-color, box-shadow;
        transition-duration: 0.15s, 0.15s, 0.15s;
        transition-timing-function: ease-in-out, ease-in-out, ease-in-out;
        transition-delay: 0s, 0s, 0s;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.6em + 1.21875rem);
        padding: 0.54688rem 0.875rem;
        font-weight: 400;
        cursor: pointer;
        line-height: 1.6;
        color: #1e2022;
        background-color: #fff;
        border: 0.0625rem solid #e7eaf3;
        border-radius: 0.3125rem;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.6em + 1.09375rem);
        padding: 0.54688rem 0.875rem;
        line-height: 1.6;
        color: #1e2022;
        content: "Browse";
        background-color: transparent;
        border-left: inherit;
        border-radius: 0 0.3125rem 0.3125rem 0;
    }

    .spinner-border {
        position: absolute;
        top: 30%;
    }

</style>
@endpush
<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                Pengaturan
            </div>
        </div>
        <form wire:submit.prevent="update" id="form_update">
            <div class="card-body">
                @include('livewire.helper.alert-session')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <span
                                        class="text-dark fw-bolder text-capitalize fs-4 text-hover-primary cursor-pointer">
                                        Nama Website
                                    </span>
                                </div>
                            </div>
                            <div  class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" wire:model="web_name" class="form-control form-control-solid"
                                            placeholder="Ex: Presensi"/>
                                    </div>
                                    @error('web_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <span
                                        class="text-dark fw-bolder text-capitalize fs-4 text-hover-primary cursor-pointer">
                                        Logo Website
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center position-relative">
                                        @if ($logo)
                                            <img src="{{ $logo->temporaryUrl() }}" class="preview-img">
                                        @else
                                            <img src="{{ $photo ? asset($photo['value']) : 'undefined' }}" class="preview-img"
                                            onerror="this.src='{{ asset('assets/images/placeholder/logo.png') }}'">
                                        @endif

                                        <div class="spinner-border text-danger" role="status" wire:loading
                                            wire:target="logo">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore.self class="card-footer">
                                <div class="row footer-img">
                                    <input type="file" name="loader_gif" id="logoUploader" class="custom-file-input"
                                        wire:model="logo" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileUploadLoader">Select Logo</label>
                                    @error('logo')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('js')
<script>

</script>
@endpush
