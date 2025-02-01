$(document).ready(function () {
    var table = $("#myTable").DataTable({
        ajax: {
            url: "{{ route('getall') }}",
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataSrc: function (response) {
                if (response.status === 200) {
                    return response.animals;
                } else {
                    return [];
                }
            },
        },
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "species" },
            { data: "age" },
            { data: "description" },
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        '<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="' +
                        data.id +
                        '" data-name="' +
                        data.name +
                        '" data-species="' +
                        data.species +
                        '" data-age="' +
                        data.age +
                        '" data-description="' +
                        data.description +
                        '"><i class="bi bi-pencil-fill"></i></a> ' +
                        '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +
                        data.id +
                        '"><i class="bi bi-trash"></i></a>'
                    );
                },
            },
        ],
    });

    $("#myTable tbody").on("click", ".edit-btn", function () {
        var id = $(this).data("id");
        var name = $(this).data("name");
        var species = $(this).data("species");
        var age = $(this).data("age");
        var description = $(this).data("description");

        $("#edit-id").val(id);
        $("#edit-name").val(name);
        $("#edit-species").val(species);
        $("#edit-age").val(age);
        $("#edit-description").val(description);
        $("#editModal").modal("show");
    });

    $("#animal-form").submit(function (e) {
        e.preventDefault();
        const animaldata = new FormData(this);

        $.ajax({
            url: "{{ route('store') }}",
            method: "post",
            data: animaldata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == 200) {
                    alert("Saved successfully");
                    $("#animal-form")[0].reset();
                    $("#exampleModal").modal("hide");
                    $("#myTable").DataTable().ajax.reload();
                }
            },
        });
    });
});

$("#edit-form").submit(function (e) {
    e.preventDefault();
    const animaldata = new FormData(this);

    $.ajax({
        url: "{{ route('update') }}",
        method: "POST",
        data: animaldata,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.status === 200) {
                alert(response.message);
                $("#edit-form")[0].reset();
                $("#editModal").modal("hide");
                $("#myTable").DataTable().ajax.reload();
            } else {
                alert(response.message);
            }
        },
    });
});

$(document).on("click", ".delete-btn", function () {
    var id = $(this).data("id");

    if (confirm("Kamu yakin ingin menghapus data hewan ternak ini?")) {
        $.ajax({
            url: "{{ route('delete') }}",
            type: "DELETE",
            data: { id: id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response); // Debugging: log the response
                if (response.status === 200) {
                    alert(response.message); // Show success message
                    $("#myTable").DataTable().ajax.reload(); // Reload the table data
                } else {
                    alert(response.message); // Show error message
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr); // Debugging: log the error
                alert("Error: " + error); // Show generic error message
            },
        });
    }
});
