@if (session('success'))
    <div class="alert alert-success bg-success alert-dismissible fade show" role="alert">
        <span class="alert-icon align-middle">
        <span class="material-icons text-md text-white">
            <i class="fas fa-thumbs-up"></i>
        </span>
        </span>
        <span class="alert-text text-white"><strong>Sukses!</strong> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
        </button>
    </div>
@elseif(session('fail'))
    <div class="alert alert-danger bg-danger alert-dismissible fade show" role="alert">
        <span class="alert-icon align-middle">
        <span class="material-icons text-md text-white">
            <i class="fas fa-exclamation-circle"></i>
        </span>
        </span>
        <span class="alert-text text-white"><strong>Gagal!</strong> {{ session('fail') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
        </button>
    </div>
@endif
