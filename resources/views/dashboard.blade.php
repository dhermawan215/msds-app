@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="">Dashboard</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Welcome user start -->
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10">
                    <div class="info-box">
                        <div class="info-box-content">
                            <h3 class="info-box-text">Welcome, {{ $user_name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="info-box">
                        <div class="info-box-content">
                            <img src="{{ asset('assets/logo/zekindo-logo.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Welcome user end -->
            <div class="row">
                <!-- alert show start-->
                <div class="col-12">
                    @if ($alert == 'first-time')
                        <div class="alert border border-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Activate your account</h4>
                            <p>if you do not activate your email, you have a limited experience when accessing the app.</p>
                            <hr>
                            <p class="mb-0">
                            <form action="{{ route('account_request_verification') }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-success">Send email verification</button>
                            </form>
                            </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($alert == 'reminder-activated')
                        <div class="alert border border-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Activate your account</h4>
                            <p>Please check your email to activate your account, or click resend to get new email
                                verification.</p>
                            <hr>
                            <p class="mb-0">
                            <form action="{{ route('account_request_verification') }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-danger">Resend email verification</button>
                            </form>
                            </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($alert == 'email-succesfully-sent')
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Email verification has been sent</h4>
                            <p>Please check your email, to activate your account</p>
                            <hr>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @else
                    @endif

                </div>
                <!-- alert show end-->
            </div>
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box border border-primary">
                        <div class="info-box-content">
                            <span class="info-box-text">Sample Request</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3 border border-warning">
                        <div class="info-box-content ">
                            <span class="info-box-text">MSDS</span>
                            <span class="info-box-number text-danger">(coming soon)</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3 border border-warning">
                        <div class="info-box-content">
                            <span class="info-box-text">Internal Material Usage Requests</span>
                            <span class="info-box-number text-danger">(coming soon)</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-5">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistic Request Sample / Month</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="d-md-flex" id="chart-container">
                                <canvas id="chart-bar-sample-request">

                                </canvas>
                            </div><!-- /.d-md-flex -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    <div class="card">

                        <div class="card-body">
                            <h3 class="profile-username text-center">{{ $user_name }}</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>
                                        IP Address:
                                    </b>
                                    <a href="#" class="float-right">{{ $ip }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>
                                        Email:
                                    </b>
                                    <a href="#" class="float-right">{{ $user_email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>
                                        Email Verified:
                                    </b>
                                    <a href="#" class="float-right">{{ $email_verified }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>
                                        User Group:
                                    </b>
                                    <a href="#" class="float-right">{{ $user_group }}</a>
                                </li>
                            </ul>
                            <a href="{{ route('user_setting') }}" class="btn btn-primary btn-block">Profile</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <!-- Info Boxes Style 2 -->
                    <div class="info-box mb-3 bg-danger">
                        <div class="info-box-content">
                            <span class="info-box-number">Bug Reporting</span>
                            <span class="info-box-text">Email to: IT Department</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 border boder-success">
                        <div class="info-box-content">
                            <span class="info-box-number">Digsys Zekindo</span>
                            <a href="https://digsys.zekindo.co.id" class="text-success" target="_blank"><i
                                    class="fa fa-arrow-up" aria-hidden="true"></i> Go to
                                website</a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <div class="info-box mb-3 bg-primary">
                        <div class="info-box-content">
                            <span class="info-box-number">Time:
                                <h1 id="time-clocking"></h1>
                            </span>
                            <span class="info-box-text">Date:
                                <h5 id="date-clocking">{{ $date }}</h5>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('custom_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            setInterval('updateClock()', 1000);
            chartSampleRequest();
            // Set interval to reload data every 60 seconds
            setInterval(chartSampleRequest, 60000);
            //check session verification email alert
            @if (session('message'))
                mustbeVerifiedAlert();
            @endif
            @if (session('activation_success'))
                activationAlert();
            @endif
        });

        function updateClock() {
            var currentTime = new Date();
            var currentHours = currentTime.getHours();
            var currentMinutes = currentTime.getMinutes();
            var currentSeconds = currentTime.getSeconds();

            // Pad the minutes and seconds with leading zeros, if required
            currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
            currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

            // Choose either "AM" or "PM" as appropriate
            // var timeOfDay = (currentHours < 12) ? "AM" : "PM";

            // Convert the hours component to 12-hour format if needed
            // currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;

            // // Convert an hours component of "0" to "12"
            // currentHours = (currentHours == 0) ? 12 : currentHours;

            // Compose the string for display
            var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;


            $("#time-clocking").html(currentTimeString);
        }

        function chartSampleRequest() {
            var sampleRequestsChart = null;
            var csrf_token = $('meta[name="csrf_token"]').attr("content");
            $.ajax({
                url: url + '/dashboard/chart',
                method: 'POST',
                data: {
                    _token: csrf_token
                },
                success: function(response) {
                    if (sampleRequestsChart) {
                        sampleRequestsChart.destroy();
                        sampleRequestsChart = null; // Reset chart to null
                    }
                    $('#chart-bar-sample-request').remove(); // Hapus elemen canvas lama
                    $('#chart-container').append(
                        '<canvas id="chart-bar-sample-request"></canvas>'); // Buat elemen canvas baru
                    var ctx = document.getElementById('chart-bar-sample-request').getContext('2d');
                    sampleRequestsChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Sample Requests',
                                data: response.data,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Year-Month'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Total Requests'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function mustbeVerifiedAlert() {

            Swal.fire({
                title: "You must have verified your account before accessing it!",
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeInUp
                    animate__faster
                    `
                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOutDown
                    animate__faster
                    `
                }
            });
        }

        function activationAlert() {
            const messageAlert = "{{ session('activation') }}";
            Swal.fire(messageAlert);
        }
    </script>
@endpush
