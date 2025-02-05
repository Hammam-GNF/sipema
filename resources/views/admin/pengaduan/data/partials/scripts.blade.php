<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('pengaduan.getallforAdmin') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    if (response.status === 200) {
                        return response.pengaduan.map((item, index) => {
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
                    "data": "petugas.user.name",
                    "render": function(data, type, row) {
                        return row.petugas && row.petugas.user ? row.petugas.user.name : 'Tidak ada petugas';
                    }
                },
                {
                    "data": "judul_pengaduan"
                },
                {
                    "data": "deskripsi"
                },
                {
                    "data": "bukti",
                    "render": function(data) {
                        return data ? '<a href="' + data + '" target="_blank">Lihat Bukti</a>' : 'Tidak ada bukti';
                    }
                },
                {
                    "data": "tanggal_pengaduan",
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "render": function(data) {
                        let badgeClass = "";
                        switch (data) {
                            case "Menunggu Verifikasi":
                                badgeClass = "bg-secondary";
                                break;
                            case "Diproses":
                                badgeClass = "bg-warning text-dark";
                                break;
                            case "Selesai":
                                badgeClass = "bg-success";
                                break;
                            case "Ditolak":
                                badgeClass = "bg-danger";
                                break;
                            default:
                                badgeClass = "bg-light text-dark";
                        }
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center"
                }
            ],
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