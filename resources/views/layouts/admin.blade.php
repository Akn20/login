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
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    {{-- Unpoly CSS for smooth transitions --}}
    <link rel="stylesheet" href="https://unpkg.com/unpoly@3.8.0/unpoly.min.css">

    @stack('styles')
    @include('partials.head')

    <style>
        /* 1. Sidebar Persistence Styles */
        .nxl-navigation {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            height: 100vh;
            z-index: 1000;
        }

        /* Loading Progress Bar at the top */
        .up-progress-bar {
            background-color: #28a745;
            height: 3px;
        }
    </style>
</head>

<body class="app-skin-light app-header-light app-navigation-light">
    <div class="nxl-app">

        {{-- Sidebar - Stays fixed and never re-renders via Unpoly --}}
        <nav class="nxl-navigation">
            @include('partials.sidebar')
        </nav>

        <div class="nxl-main">
            <header class="nxl-header">
                @include('partials.navbar')
            </header>

            {{-- 2. Target for No-Refresh Loading --}}
            {{-- Everything inside this div will change when you click links --}}
            <main class="nxl-container" id="main-container">
                <div class="nxl-content">
                    @yield('content')
                </div>

                @include('partials.footer')
            </main>
        </div>

    </div>

    {{-- Essential Scripts --}}
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>

    {{-- 3. Unpoly Library for AJAX Navigation --}}
    <script src="https://unpkg.com/unpoly@3.8.0/unpoly.min.js"></script>

    @stack('scripts')

    <script>
        { { --4. Status Toggle Logic(Optimized for No - Refresh) --} }
        document.addEventListener('DOMContentLoaded', function () {
            // Unpoly event that runs every time new content is loaded via AJAX
            up.on('up:content:updated', function () {
                initializeStatusToggles();
            });

            // Initial run on first page load
            initializeStatusToggles();

            function initializeStatusToggles() {
                document.querySelectorAll('.status-toggle-input').forEach(function (toggle) {
                    // Prevent multiple event listeners
                    if (toggle.dataset.initialized) return;
                    toggle.dataset.initialized = "true";

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

                                // 5. Removed location.reload() to maintain the no-refresh experience
                                if (isVip) {
                                    text.innerText = data.is_active ? 'Yes' : 'No';
                                } else {
                                    text.innerText = data.is_active ? 'Active' : 'Inactive';
                                }
                            })
                            .catch(() => {
                                alert('Something went wrong!');
                                checkbox.checked = !checkbox.checked;
                            });
                    });
                });
            }
        });

        { { --6. Scroll Position Persistence-- } }
        const scrollContainer = document.querySelector('.navbar-content');
        if (scrollContainer) {
            // Restore position from local storage
            scrollContainer.scrollTop = localStorage.getItem('sidebarScroll') || 0;

            // Save position whenever scrolling happens
            scrollContainer.addEventListener('scroll', () => {
                localStorage.setItem('sidebarScroll', scrollContainer.scrollTop);
            });
        }
    </script>
</body>

</html>