{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title', 'Admin Dashboard')</title>

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/dataTables.bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/tagify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/tagify-data.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/quill.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    @stack('styles')
    @include('partials.head')
</head>

<body class="app-skin-light app-header-light app-navigation-light">
    <div class="nxl-app">

        {{-- Sidebar --}}
        <nav class="nxl-navigation">
            @include('partials.sidebar')
        </nav>

        <div class="nxl-main">
            {{-- Top navbar --}}
            <header class="nxl-header">
                @include('partials.navbar')
            </header>

            {{-- Page content --}}
            <main class="nxl-container">
                <div class="nxl-content">
                    @yield('content')
                </div>

                @include('partials.footer')
            </main>
        </div>

    </div>

    @include('partials.scripts')

    {{-- Core vendor JS (must be before page-specific scripts) --}}
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    {{-- Disable theme demo dashboard charts to avoid conflicts --}}
    {{--
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

    {{-- Page-specific scripts defined with @section('scripts') --}}
    @yield('scripts')

    {{-- Page-specific scripts defined with @push('scripts') --}}
    @stack('scripts')
</body>

</html>