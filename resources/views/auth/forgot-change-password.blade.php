<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome-free/css/all.min.css') }}">
    <title>Forgot Password - Change Password</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon/favicon-16x16.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/toastr/toastr.css') }}">

</head>

<body>

    <section class="bg-white py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card bg-primary border-0 rounded-5">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h3>Forgot password</h3>

                                    </div>
                                </div>
                            </div>
                            <form action="javascript:;" method="post" id="form-forgot-password">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group mb-3">
                                    <label for="">New password</label>
                                    <input type="password" class="form-control" placeholder="passsword"
                                        name="new_password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Re type new password</label>
                                    <input type="password" class="form-control" placeholder="password"
                                        name="confirm_password">
                                </div>

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-light btn-block">Change password</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="row mt-2">
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <a href="{{ route('login') }}" class="text-white">Login</a>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#form-forgot-password").submit(function(e) {
                e.preventDefault();
                const form = $(this);
                let formData = new FormData(form[0]);
                $.ajax({
                    url: "{{ route('forgot_password.change_password_process') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(responses) {
                        toastr.success(responses.message);
                        setTimeout(() => {
                            window.location.href = responses.url;
                        }, 4500);
                    },
                    error: function(response) {
                        $.each(response.responseJSON, function(key, value) {
                            toastr.error(value);
                        });
                    },
                });
            });
        });
    </script>
</body>

</html>
