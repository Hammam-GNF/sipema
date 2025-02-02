<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="petugas-form" method="post" action="{{ route('petugas.store') }}" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); focusNextInput(event); }">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <label>Nama</label>
                            <input type="text" name="name" id="name" class="form-control" onblur="this.style.backgroundColor='';" required>
                        </div>
                        <div class="col-lg">
                            <label>Role</label>
                            <select name="role" id="role" class="form-control" onblur="this.style.backgroundColor='';" required>
                                <option value="disabled selected">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" onblur="this.style.backgroundColor='';">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" onblur="this.style.backgroundColor='';">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="petugas-form">Simpan</button>
            </div>
        </div>
    </div>
</div>