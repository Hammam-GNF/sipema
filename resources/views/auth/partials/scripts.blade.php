<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(event) {
            event.preventDefault();

            $('.alert').remove();

            var email = $('#email').val();
            var password = $('#password').val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            var formData = {
                email: email,
                password: password,
                _token: _token
            };

            $.ajax({
                url: "{{ route('actionLogin') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire(
                            'Login Berhasil!',
                            response.message,
                            'success'
                        ).then(function() {
                            window.location.href = response.redirect_url;
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            response.message || 'Login failed!',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;

                    if (response.status === 422) {
                        if (response.errors.email) {
                            $('#email').after('<div class="alert alert-danger">' + response.errors.email[0] + '</div>');
                        }
                        if (response.errors.password) {
                            $('#password').after('<div class="alert alert-danger">' + response.errors.password[0] + '</div>');
                        }
                    } else {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat login. Silakan coba lagi.',
                            'error'
                        );
                    }
                }
            });
        });
    });
</script>