async function alertHapus(title = null, text = null){
    konfirmasi = await Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus data!'
    })
    return konfirmasi
}

async function logout(){
    konfirmasi = await Swal.fire({
        title: 'Warning!!!',
        text: 'Anda yakin ingin keluar???',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Keluar!'
    })

    if(konfirmasi.isConfirmed == true){
        $('#form_logout').submit()
    }
}
