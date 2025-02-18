<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor6">


<!-- Mirrored from codervent.com/rocker/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 May 2024 15:05:17 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('images/kapal-api.png') }}" type="image/png" />
    <!--plugins-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/select2@4.1.0-rc.0/dist/css/select2.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css') }}" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/swal/swal.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" /> --}}
    <title>
        @stack('tittle')
    </title>

    <style>
        /* th:last-child,
  td:last-child {
   position: sticky;
   right: 0px;
   background-color: #ffff;
   z-index: 1;

  } */
    </style>
    @stack('css')
</head>

<body>
    <!--wrapper-->
    @include('sweetalert::alert')
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            {{-- <div class="sidebar-header">
				
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			 </div> --}}
            <!--navigation-->
            @include('layouts.sidebar')
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        @include('layouts.header')
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                @if ($errors->any())
                    <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-dark"><i class='bx bx-info-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-dark">Warning Alerts</h6>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>

        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2024. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->


    <!-- search modal -->
    @include('layouts.searchmodal')
    <!-- end search modal -->


    <!--start switcher-->
    {{-- @include('layouts.switcher') --}}
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <!--notification js -->
    <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
    <script src="{{ asset('assets/swal/swal.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        new PerfectScrollbar(".app-container")

        @if (session()->has('success'))
            // Lobibox.notify('success', {
            //     pauseDelayOnHover: true,
            //     size: 'mini',
            //     rounded: true,
            //     delayIndicator: false,
            //     continueDelayOnInactiveTab: false,
            //     position: 'top right',
            //     icon: 'bx bx-check-circle',
            // msg: 'Sukses<br>{{ session()->get('success') }}'
            // });
            Swal.fire({
                title: "SUKSES!",
                text: '{{ session()->get('success') }}',
                icon: "success"
            });
        @endif
        @if (session()->has('danger'))
            // Lobibox.notify('error', {
            //     pauseDelayOnHover: true,
            //     size: 'mini',
            //     rounded: true,
            //     delayIndicator: false,
            //     icon: 'bx bx-x-circle',
            //     continueDelayOnInactiveTab: false,
            //     position: 'top right',
            //     msg: 'Danger <br>{{ session()->get('danger') }}'
            // });
            Swal.fire({
                icon: "error",
                title: 'Danger <br>{{ session()->get('danger') }}'
                text: "",
                // footer: '<a href="#">Why do I have this issue?</a>'
            });
        @endif
    </script>

    @stack('js')
</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 May 2024 15:05:54 GMT -->

</html>
