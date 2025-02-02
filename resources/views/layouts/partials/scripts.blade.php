<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('petugas.count') }}",
            type: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    $('#total-petugas').text(response.totalPetugas);
                } else {
                    $('#total-petugas').text('Error fetching data');
                }
            },
            error: function() {
                $('#total-petugas').text('Error fetching data');
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('kategori.count') }}",
            type: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    $('#total-kategori').text(response.totalKategori);
                } else {
                    $('#total-kategori').text('Error fetching data');
                }
            },
            error: function() {
                $('#total-kategori').text('Error fetching data');
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('pengaduan.count') }}",
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
</script>