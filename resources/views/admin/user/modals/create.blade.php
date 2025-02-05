<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="user-form" method="post" action="{{ route('user.store') }}" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); focusNextInput(event); }">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" onblur="this.style.backgroundColor='';" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="kategori-form">Simpan</button>
            </div>
        </div>
    </div>
</div>
