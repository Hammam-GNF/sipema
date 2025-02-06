<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('pengaduan.countforPetugas') }}",
            type: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    $('#total-pengaduan').text(response.totalPengaduan);
                } else {
                    $('#total-pengaduan').text('Error fetching data');
                }
            },
            error: function() {
                $('#total-pengaduan').text('Error fetching data');
            }
        });
    });

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