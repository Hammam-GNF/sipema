<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createMedicalRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPengaduanModalLabel">Tambah Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pengaduan-form" method="post" action="{{ route('pengaduan.store') }}" onkeydown="if(event.key === 'Enter'){ event.preventDefault(); focusNextInput(event); }">
                    @csrf
                    <!-- Form fields go here -->
                    <div class="row">
                        <div class="col-lg">
                            <label>Hewan</label>
                            <select name="animal_id" id="create-animal_id" class="form-control" >
                                <!-- Populate with animals from database -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control" onfocus="this.style.backgroundColor='lightblue';" onblur="this.style.backgroundColor='';">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Deskripsi</label>
                            <input type="text" name="description" id="description" class="form-control" onfocus="this.style.backgroundColor='lightblue';" onblur="this.style.backgroundColor='';">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Perawatan</label>
                            <textarea name="treatment" id="treatment" class="form-control" onfocus="this.style.backgroundColor='lightblue';" onblur="this.style.backgroundColor='';"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Dokter</label>
                            <input type="text" name="veterinarian" id="veterinarian" class="form-control" onfocus="this.style.backgroundColor='lightblue';" onblur="this.style.backgroundColor='';">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="medical-form">Simpan</button>
            </div>
        </div>
    </div>
</div>
