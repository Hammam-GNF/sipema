<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('kategori.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    if (response.status === 200) {
                        return response.kategori.map((item, index) => {
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
                    "data": "nama_kategori"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" edit-btn" data-id_kategori="' + data.id_kategori + '" data-nama_kategori="' + data.nama_kategori + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id_kategori="' + data.id_kategori + '"><i class="bi bi-trash"></i></a>';
                    }
                }
            ]
        });

        // Handle edit button click
        $('#myTable tbody').on('click', '.edit-btn', function() {
            var id_kategori = $(this).data('id_kategori');
            var nama_kategori = $(this).data('nama_kategori');

            $('#edit-id').val(id_kategori);
            $('#edit-nama_kategori').val(nama_kategori);

            $('#editModal').modal('show');
        });

        // Handle add form submission
        $('#kategori-form').submit(function(e) {
            e.preventDefault();
            const kategoridata = new FormData(this);

            $.ajax({
                url: '{{ route("kategori.store") }}',
                method: 'post',
                data: kategoridata,
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

                        $('#kategori-form')[0].reset();
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
            const kategoridata = new FormData(this);

            $.ajax({
                url: '{{ route("kategori.update") }}',
                method: 'POST',
                data: kategoridata,
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
                            showConfirmButton: false
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
            var id_kategori = $(this).data('id_kategori');
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data kategori ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("kategori.delete") }}',
                        type: 'DELETE',
                        data: {
                            id_kategori: id_kategori
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
        const inputs = document.querySelectorAll('#kategori-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }
</script>