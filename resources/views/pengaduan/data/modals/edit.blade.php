<div class="modal fade" id="editPengaduanModal" tabindex="-1" role="dialog"
    aria-labelledby="editPengaduanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPengaduanModalLabel">Edit Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pengaduan-update-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="row">
                        <div class="col-lg">
                            <label>Hewan</label>
                            <select name="animal_id" id="edit-animal_id" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Tanggal</label>
                            <input type="date" name="date" id="edit-date" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Deskripsi</label>
                            <input type="text" name="description" id="edit-description" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Perawatan</label>
                            <textarea name="treatment" id="edit-treatment" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Dokter</label>
                            <input type="text" name="veterinarian" id="edit-veterinarian" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="pengaduan-update-form">Simpan</button>
            </div>
        </div>
    </div>
</div>