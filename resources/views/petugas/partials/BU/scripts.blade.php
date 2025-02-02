<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('petugas.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    if (response.status === 200) {
                        return response.petugas;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { "data": "id_petugas", "className": "text-center" },
                { "data": "name" },
                { "data": "email" },
                { "data": "role" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="' + data.id + '" data-name="' + data.name + '" data-email="' + data.email + '" data-role="' + data.role + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '"><i class="bi bi-trash"></i></a>';
                    }
                }
            ]
        });

        // Handle edit button click
        $('#myTable tbody').on('click', '.edit-btn', function () {
            var id_petugas = $(this).data('id_petugas');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var role = $(this).data('role');

            $('#edit-id').val(id_petugas);
            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#edit-role').val(role);

            $('#editModal').modal('show');
        });

        // Handle add form submission
        $('#petugas-form').submit(function (e) {
            e.preventDefault();
            const petugasdata = new FormData(this);

            $.ajax({
                url: '{{ route("petugas.store") }}',
                method: 'post',
                data: petugasdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status == 200) {
                        alert("Saved successfully");
                        $('#petugas-form')[0].reset();
                        $('#createModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    }
                }
            });
        });

        // Handle edit form submission
        $('#edit-form').submit(function (e) {
            e.preventDefault();
            const petugasdata = new FormData(this);

            $.ajax({
                url: '{{ route("petugas.update") }}',
                method: 'POST',
                data: petugasdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 200) {
                        alert(response.message);
                        $('#edit-form')[0].reset();
                        $('#editModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.delete-btn', function () {
            var id_petugas = $(this).data('id_petugas');
            if (confirm('Kamu yakin ingin menghapus data petugas ini?')) {
                $.ajax({
                    url: '{{ route("petugas.delete") }}',
                    type: 'DELETE',
                    data: { id_petugas: id_petugas },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            alert(response.message);
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            }
        });
    });

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#petugas-form input');
            let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

</script>