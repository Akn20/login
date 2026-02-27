{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <style>
        .status-toggle {
            width: 100px;
            height: 30px;
            border-radius: 50px;
            border: none;
            position: relative;
            cursor: pointer;
            transition: 0.3s;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            padding: 0 12px;
            display: flex;
            align-items: center;
        }

        /* Active */
        .status-toggle.active {
            background: #28a745;
            justify-content: flex-end;
            /* text on right */
        }

        /* Inactive */
        .status-toggle.inactive {
            background: #dc3545;
            justify-content: flex-start;
            /* text on left */
        }

        /* White circle */
        .status-toggle::before {
            content: "";
            position: absolute;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: white;
            top: 4px;
            transition: 0.3s;
        }

        /* Circle position */
        .status-toggle.active::before {
            left: 4px;
        }

        .status-toggle.inactive::before {
            right: 4px;
        }

        /* Keep text above */
        .status-toggle span {
            position: relative;
            z-index: 2;
        }
    </style>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script> 

        {{-- Toggle Script --}}
       <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.status-toggle-input').forEach(function (toggle) {

                toggle.addEventListener('change', function () {

                    const checkbox = this;
                    const url = checkbox.dataset.url;
                    const wrapper = checkbox.closest('.status-toggle-wrapper');
                    const text = wrapper.querySelector('.status-toggle-text');
                    const isVip = wrapper.dataset.type === 'vip';

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (!data.success) return;

                       
                        checkbox.checked = data.is_active;

                        if (isVip) {
                            text.innerText = data.is_active ? 'Yes' : 'No';
                        } else {
                            text.innerText = data.is_active ? 'Active' : 'Inactive';
                        }
                            
                        location.reload();
                        
                    })
                  
                    .catch(() => {
                        alert('Something went wrong!');
                        checkbox.checked = !checkbox.checked;
                    });

                });

            });

        });
        </script>
                        
        });
</script>
</body>

</html>