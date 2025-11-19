<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Approx Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" />

    <!-- CSS -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" />
    @stack('styles')
</head>

<body>
    {{-- Include Header --}}
    @include('admin.header')

    {{-- Main Content Area --}}
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="footer text-center text-sm-start d-print-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- <p class="text-muted mb-0">
                        © <script>document.write(new Date().getFullYear())</script> Approx
                        <span class="text-muted d-none d-sm-inline-block float-end">
                            Design with <i class="iconoir-heart-solid text-danger align-middle"></i> by Mannatthemes
                        </span>
                    </p> -->
                </div>
            </div>
        </div>
    </footer>

    {{-- JS Scripts --}}
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>