<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('notifikasi.getallforPetugas') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    if (response.status === 200) {
                        return response.notifikasi.map((item, index) => {
                            item.iteration = index + 1;
                            return item;
                        });
                    } else {
                        return [];
                    }
                }
            },
            "columns": [{
                    "data": "iteration",
                    "className": "text-center"
                },
                {
                    "data": "user.name",
                    "render": function(data, type, row) {
                        return row.user ? row.user.name : 'Tidak ada pengguna';
                    }
                },
                {
                    "data": "pengaduan.judul_pengaduan",
                    "render": function(data, type, row) {
                        return row.pengaduan ? row.pengaduan.judul_pengaduan : 'Tidak ada judul Pengaduan';
                    }
                },
                {
                    "data": "pesan",
                },
                {
                    "data": "status_baca",
                    "render": function(data) {
                        let badgeClass = "";
                        let statusText = "";

                        switch (data) {
                            case 0:
                                badgeClass = "bg-secondary";
                                statusText = "Belum Terbaca";
                                break;
                            case "1":
                            case 1:
                                badgeClass = "bg-warning text-dark";
                                statusText = "Terbaca";
                                break;
                            default:
                                badgeClass = "bg-light text-dark";
                                statusText = "Status Tidak Dikenal";
                        }

                        return `<span class="badge ${badgeClass}">${statusText}</span>`;
                    },
                    "className": "text-center"
                }

            ]
        });

        // Handle edit button click
        $('#myTable tbody').on('click', '.edit-btn', function() {
            var id_pengaduan = $(this).data('id_pengaduan');
            var id_petugas = $(this).data('id_petugas');
            var judul_pengaduan = $(this).data('judul_pengaduan');
            var tanggal_pengaduan = $(this).data('tanggal_pengaduan');
            var deskripsi = $(this).data('deskripsi');
            var status = $(this).data('status');

            $('#edit-id').val(id_pengaduan);
            $('#edit-id_petugas').val(id_petugas);
            $('#edit-judul_pengaduan').val(judul_pengaduan);
            $('#edit-tanggal_pengaduan').val(tanggal_pengaduan);
            $('#edit-deskripsi').val(deskripsi);
            $('#edit-status').val(status);

            $('#editModal').modal('show');
        });

        // Handle add form submission
        $('#pengaduan-form').submit(function(e) {
            e.preventDefault();
            const pengaduandata = new FormData(this);

            $.ajax({
                url: '{{ route("pengaduan.store") }}',
                method: 'post',
                data: pengaduandata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#pengaduan-form')[0].reset();
                        $('#createModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi Kesalahan! Coba lagi nanti.';

                    if (xhr.status == 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorText = "";

                        $.each(errors, function(key, value) {
                            errorText += value[0] + "<br>";
                        });

                        errorMessage = errorText;
                    }

                    Swal.fire({
                        title: "Gagal!",
                        html: errorMessage,
                        icon: "error"
                    });
                }
            });
        });

        // Handle edit form submission
        $('#edit-form').submit(function(e) {
            e.preventDefault();
            const pengaduandata = new FormData(this);

            $.ajax({
                url: '{{ route("pengaduan.update") }}',
                method: 'POST',
                data: pengaduandata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#edit-form')[0].reset();
                        $('#editModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: true
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan! Coba lagi nanti.';

                    if (xhr.status == 422 && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let errorText = "";

                        $.each(errors, function(key, value) {
                            errorText += value[0] + "<br>";
                        });

                        errorMessage = errorText;
                    }

                    Swal.fire({
                        title: "Gagal!",
                        html: errorMessage,
                        icon: "error"
                    });
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function() {
            var id_pengaduan = $(this).data('id_pengaduan');
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data pengaduan ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("pengaduan.delete") }}',
                        type: 'DELETE',
                        data: {
                            id_pengaduan: id_pengaduan
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                );
                                $('#myTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#pengaduan-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

    // Konfirmasi Logout
    $(document).ready(function() {
        $('#logoutButton').click(function(e) {
            e.preventDefault();

            var _token = $('meta[name="csrf-token"]').attr('content');
            var formData = {
                _token: _token
            };

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari akun Anda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('logout') }}",
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire(
                                    'Logout Berhasil!',
                                    'Anda berhasil keluar dari akun.',
                                    'success'
                                ).then(function() {
                                    window.location.href = response.redirect_url || "{{ route('login') }}";
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    response.message || 'Logout gagal dilakukan.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat logout. Silakan coba lagi.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>