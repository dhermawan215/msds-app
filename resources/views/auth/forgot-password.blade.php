<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome-free/css/all.min.css') }}">
    <title>Forgot Password</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon/favicon-16x16.png') }}">

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
                            <form action="{{ route('forgot_password.process') }}" method="post"
                                id="form-forgot-password">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-light btn-block">Send email</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('forgot_password'))
            const forgotPasswordMessage = "{{ session('forgot_password') }}";
            Swal.fire(forgotPasswordMessage);
        @endif
    </script>
</body>

</html>
