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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.0/dist/css/tom-select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Unpoly CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/unpoly@3.8.0/unpoly.min.css">

    @stack('styles')
    @include('partials.head')

    <style>
        /* 1. FORCE SIDEBAR FIXED POSITION */
        .nxl-navigation {
            position: fixed !important;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px !important;
            height: 100vh !important;
            z-index: 1050;
            background: #fff;
            border-right: 1px solid #e3e7ed;
            overflow: hidden;
        }

        /* 2. FIX HEADER OFFSET */
        .nxl-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 260px !important;
            /* Offset by sidebar width */
            width: calc(100% - 260px) !important;
            height: 70px;
            z-index: 1040;
            background: #fff;
        }

        /* 3. FIX MAIN CONTENT OVERLAP (THE BIG FIX) */
        .nxl-main {
            margin-left: 0px !important;
            /* Moves content to the right */
            padding-top: 0px !important;
            /* Moves content below navbar */
            min-height: fit-content;
            background: #f4f7fa;
            display: flex;
            flex-direction: column;
        }

        .nxl-container {
            flex: 1;
            width: auto;
            padding: 25px;
        }

        /* Loading Progress Bar for Unpoly */
        .up-progress-bar {
            background-color: #28a745;
            height: 3px;
        }

        /* Your Status Toggle Styles */
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

        .status-toggle.active {
            background: #28a745;
            justify-content: flex-end;
        }

        .status-toggle.inactive {
            background: #dc3545;
            justify-content: flex-start;
        }

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

        .status-toggle.active::before {
            left: 4px;
        }

        .status-toggle.inactive::before {
            right: 4px;
        }

        .status-toggle span {
            position: relative;
            z-index: 2;
        }

       .custom-modal {
    display: none;
    position: fixed;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background: transparent; /* NO BLUR */
    z-index: 9999;
}

.custom-modal-content {
    background: #fff;
    padding: 20px;
    width: 500px;
    height: auto;
    margin: 10% auto;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

    </style>
</head>

<body class="app-skin-light app-header-light app-navigation-light">
    <div class="nxl-app">

        {{-- Sidebar - up-fixed keeps it from disappearing during AJAX loads --}}
        <aside class="nxl-navigation" up-fixed>
            @include('partials.sidebar')
        </aside>

        <div class="nxl-main">
            {{-- Top navbar --}}
            <header class="nxl-header">
                @include('partials.navbar')
            </header>

            {{-- THE AJAX TARGET: Only content inside #main-container will refresh --}}
            <main class="nxl-container" id="main-container">
                <div class="nxl-content" up-main>
                    
                    @yield('content')
                </div>
                @include('partials.footer')
            </main>
        </div>

    </div>

    {{-- SCRIPTS --}}
    @include('partials.scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/unpoly@3.8.0/unpoly.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    {{-- YOUR ORIGINAL SCRIPT (KEPT INTACT) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Safety Catch for Unpoly: Re-run logic when content updates
            up.on('up:content:updated', function () {
                initializeStatusToggles();
            });

            function initializeStatusToggles() {
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
                                location.reload(); // Your original reload logic
                            })
                            .catch(() => {
                                alert('Something went wrong!');
                                checkbox.checked = !checkbox.checked;
                            });
                    });
                });
            }
            initializeStatusToggles();
        });

        // 4. SIDEBAR SCROLL PERSISTENCE SCRIPT
        const scrollArea = document.getElementById('sidebar-scroll-area');
        if (scrollArea) {
            scrollArea.scrollTop = localStorage.getItem('sidebar_scroll_pos') || 0;
            scrollArea.addEventListener('scroll', () => {
                localStorage.setItem('sidebar_scroll_pos', scrollArea.scrollTop);
            });
            up.on('up:link:follow', () => {
                localStorage.setItem('sidebar_scroll_pos', scrollArea.scrollTop);
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically apply Unpoly logic to all sidebar links
            document.querySelectorAll('.nxl-navigation a').forEach(link => {
                if (link.getAttribute('href') && link.getAttribute('href') !== 'javascript:void(0);') {
                    link.setAttribute('up-follow', '');
                    link.setAttribute('up-target', '#main-container');
                }
            });
        });
    </script>

    <script>
function openModal(id) {
    document.getElementById('rejectModal' + id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById('rejectModal' + id).style.display = 'none';
}
</script>
</body>

</html>