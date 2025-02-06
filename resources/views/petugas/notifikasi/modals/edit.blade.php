<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Perbaharui Data Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="post">
                    @csrf
                    <input type="hidden" id="edit-id" name="id_pengaduan">
                    <div class="row">
                        <div class="col-lg">
                            <label>Judul Pengaduan</label>
                            <input type="text" id="edit-judul_pengaduan" name="judul_pengaduan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="edit-deskripsi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Bukti (Opsional)</label>
                            <input type="file" name="bukti" id="edit-bukti" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Tanggal Pengaduan</label>
                            <input type="date" name="tanggal_pengaduan" id="edit-tanggal_pengaduan" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="edit-form">Simpan</button>
            </div>
        </div>
    </div>
</div>