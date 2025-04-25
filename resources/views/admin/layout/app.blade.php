{{-- resources/views/admin/layout/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title','Dashboard') | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Admin dashboard" />
    <meta name="author" content="You" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    {{-- Core vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons.min.css') }}">

    {{-- Theme --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.min.css') }}" id="app-style">

    {{-- 3rd-party plugins used in the forms --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/quill/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/js/dropzone/dropzone.css') }}">

    {{-- Blade stack for page-specific CSS --}}
    @stack('css')
</head>
<body>
    <div class="wrapper">
        {{-- Sidebar --}}
        @include('admin.layout.sidebar')

        {{-- Topbar --}}
        @include('admin.layout.header')

        {{-- Page content --}}
        <div class="page-content">
            @yield('content')

            {{-- Footer --}}
            @include('admin.layout.footer')
        </div>
    </div>

    {{-- Off-canvas theme settings panel (optional) --}}
    @includeWhen(View::exists('admin.layout.theme-settings'),'admin.layout.theme-settings')

    {{-- Core vendor JS --}}
    <script src="{{ asset('admin/assets/js/vendor.min.js') }}"></script>

    {{-- CDN fallback in case jQuery wasn’t bundled in vendor.min.js --}}
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
    </script>

    {{-- Core theme JS --}}
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>

    {{-- 3rd-party plugins --}}
    <script src="{{ asset('admin/assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone/dropzone.min.js') }}"></script>

    {{-- Blade stack for page-specific scripts --}}
    @stack('scripts')

    {{-- Section for one-off scripts (alt. to stack) --}}
    @yield('scripts')
</body>
</html>