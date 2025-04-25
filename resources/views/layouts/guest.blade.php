
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <!-- Vendor css -->
    <link href="{{ asset('admin/assets/css/vendor.min.css') }}" rel="stylesheet" />

    <!-- App css -->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" />
</head>

<body class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
    <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
        <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                <a href="/" class="auth-brand mb-3">
                    <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="dark logo" height="30" class="logo-dark">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="logo light" height="30" class="logo-light">
                </a>

               {{$slot}}

                <p class="mt-auto mb-0">
                    © <script>document.write(new Date().getFullYear())</script> {{ config('app.name') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('admin/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
</body>
</html>