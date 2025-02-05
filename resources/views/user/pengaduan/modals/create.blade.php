<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createPengaduanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPengaduanModalLabel">Tambah Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pengaduan-form" method="post" action="{{ route('pengaduan.store') }}" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); focusNextInput(event); }">
                    @csrf
                    <!-- Form fields go here -->
                    <div class="row">
                        <div class="col-lg">
                            <label>Judul Pengaduan</label>
                            <input type="text" name="judul_pengaduan" id="judul_pengaduan" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Bukti (Opsional)</label>
                            <input type="file" name="bukti" id="bukti" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Tanggal Pengaduan</label>
                            <input type="date" name="tanggal_pengaduan" id="tanggal_pengaduan" class="form-control" required>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="Menunggu Verifikasi">
                    <input type="hidden" name="id_user" id="id_user" value="{{ auth()->id() }}">
                    <input type="hidden" name="id_petugas" id="id_petugas">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="pengaduan-form">Simpan</button>
            </div>
        </div>
    </div>
</div>