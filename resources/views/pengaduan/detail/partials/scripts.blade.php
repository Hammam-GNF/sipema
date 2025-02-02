<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        // Mengisi dropdown hewan saat halaman dimuat
        $.ajax({
            url: '{{ route("pengaduan.getall") }}',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 200) {
                    var kategoriSelect = $('#create-kategori_id');
                    kategoriSelect.empty();
                    $.each(response.kategori, function(index, kategori) {
                        kategoriSelect.append($('<option>', {
                            value: kategori.id_kategori,
                            text: kategori.name
                        }));
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching kategori:', error);
            }
        });

        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('pengaduan.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    if (response.status === 200) {
                        return response.pengaduan;
                    } else {
                        return [];
                    }
                }

            },
            "columns": [{
                    "data": "id_pengaduan",
                    "className": "text-center"
                },
                {
                    "data": "petugas.name",
                    "render": function(data, type, row) {
                        return row.petugas ? row.petugas.name : '';
                    }
                },
                {
                    "data": "kategori.nama_kategori",
                    "render": function(data, type, row) {
                        return row.kategori ? row.kategori.nama_kategori : '';
                    }
                },
                {
                    "data": "deskripsi"
                },
                {
                    "data": "status"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" edit-btn" data-id_pengaduan="' + data.id_pengaduan + '" data-id_petugas="' + data.id_petugas + '" data-id_kategori="' + data.id_kategori + '" data-deskripsi="' + data.deskripsi + '" data-status="' + data.status + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id_pengaduan="' + data.id_pengaduan + '"><i class="bi bi-trash"></i></a>';
                    }
                }
            ],
        });

        // Mengisi dropdown hewan saat halaman dimuat
        $.ajax({
            url: '{{ route("pengaduan.getall") }}',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 200) {
                    var kategoriSelect = $('#edit-id_kategori');
                    kategoriSelect.empty(); // Kosongkan elemen dropdown
                    $.each(response.kategoris, function(index, kategori) {
                        kategoriSelect.append($('<option>', {
                            value: kategori.id_kategori,
                            text: kategori.name
                        }));
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching kategori:', error);
            }
        });

        $('#myTable tbody').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var id_kategori = $(this).data('id_kategori');
            var date = $(this).data('date');
            var description = $(this).data('description');
            var treatment = $(this).data('treatment');
            var veterinarian = $(this).data('veterinarian');

            $('#edit-id').val(id);
            $('#edit-id_kategori').val(id_kategori);
            $('#edit-date').val(date);
            $('#edit-description').val(description);
            $('#edit-treatment').val(treatment);
            $('#edit-veterinarian').val(veterinarian);
            $('#editPengaduanModal').modal('show');
        });


        $('#pengaduan-form').submit(function(e) {
            e.preventDefault();
            const pengaduanData = new FormData(this);

            $.ajax({
                url: '{{ route("pengaduan.store") }}',
                method: 'POST',
                data: pengaduanData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 200) {
                        alert(response.message);
                        $('#pengaduan-form')[0].reset();
                        $('#createModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += errors[field] + '\n';
                    }
                    alert('Validation errors:\n' + errorMessages);
                }
            });
        });

        $('#pengaduan-update-form').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const pengaduan = $('#edit-id').val();

            $.ajax({
                url: `/pengaduan/update/${pengaduan}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.status === 200) {
                        alert(response.message);
                        $('#editPengaduanModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        errorMessages += errors[field] + '\n';
                    }
                    alert('Validation errors:\n' + errorMessages);
                }
            });
        });

        $('#myTable tbody').on('click', '.delete-btn', function() {
            var id = $(this).data('id');

            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '{{ route("pengaduan.delete") }}',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert(response.message);
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            }
        });
    });

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#pengaduan-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }
</script>