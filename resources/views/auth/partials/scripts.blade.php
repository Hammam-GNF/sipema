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

            var $submitButton = $('.login100-form-btn');
            var originalText = $submitButton.text();

            $submitButton.text('Loading...').prop('disabled', true);

            $.ajax({
                url: "{{ route('actionLogin') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                success: function(response) {
                    if (response.status === 200) {
                        let timerInterval;
                        Swal.fire({
                            title: 'Login Berhasil!',
                            html: 'Proses login berhasil, mengalihkan dalam <b></b> detik.',
                            timer: 3000, // 3 detik
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Math.floor(Swal.getTimerLeft() / 1000)}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then(function() {
                            window.location.href = response.redirect_url;
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            response.message || 'Login failed!',
                            'error'
                        );
                        $submitButton.text(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;

                    if (xhr.status === 422 && response.errors) {
                        $('.alert-danger').remove();

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
                    $submitButton.text(originalText).prop('disabled', false);
                }
            });
        });

        // register
        $('#registerForm').submit(function(event) {
            event.preventDefault();
            $('.alert').remove();
            var formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                role: $('#role').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            var $submitButton = $('.login100-form-btn');
            var originalText = $submitButton.text();
            $submitButton.text('Loading...').prop('disabled', true);
            $.ajax({
                url: "{{ route('actionRegister') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': formData._token
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Registrasi Berhasil!',
                        text: 'Silakan periksa email untuk verifikasi.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    if (xhr.status === 422 && response.errors) {
                        $.each(response.errors, function(key, messages) {
                            $('#' + key).after('<div class="alert alert-danger">' + messages[0] + '</div>');
                        });
                    } else {
                        Swal.fire('Error!', 'Terjadi kesalahan saat registrasi.', 'error');
                    }
                    $submitButton.text(originalText).prop('disabled', false);
                }
            });
        });
    });
</script>