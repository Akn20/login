@extends('layouts.admin')

@section('page-title', 'Dashboard | ' . config('app.name'))

@section('content')
    <div class="main-content">
        <div class="row">
            <!-- [Organization] start -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-home"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">
                                Organizations
                            </h3>
                        </div>

                        <div class="text-center mb-3">
                            <div class="fs-3 fw-bold text-dark">
                                <span class="counter">{{ $organizationCount }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between fs-12 mb-1">
                            <span class="text-success">
                                Active: {{ $activeOrganizations }}
                            </span>
                            <span class="text-danger">
                                Inactive: {{ $inactiveOrganizations }}
                            </span>
                        </div>

                        <div class="progress mt-2 ht-3">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $activeOrganizationPercentage }}%"></div>
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ 100 - $activeOrganizationPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Organization] end -->

            <!-- [Hospitals] start -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-plus-square"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">
                                Hospitals
                            </h3>
                        </div>

                        <div class="text-center mb-2">
                            <div class="fs-3 fw-bold text-dark">
                                <span class="counter">{{ $hospitalTotal }}</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="d-flex justify-content-between fs-12 mb-1">
                                <span class="text-success">
                                    Active: {{ $activeHospitals }}
                                </span>
                                <span class="text-danger">
                                    Inactive: {{ $inactiveHospitals }}
                                </span>
                            </div>

                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-success" style="width: {{ $activeHospitalPercentage }}%"></div>
                                <div class="progress-bar bg-danger" style="width: {{ 100 - $activeHospitalPercentage }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Hospitals] end -->

            <!-- [Users] start -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-users"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">
                                Users
                            </h3>
                        </div>

                        <h2 class="fw-bold mb-3 text-center">
                            {{ $userCount }}
                        </h2>

                        <div class="w-100 mt-2">
                            <div class="d-flex justify-content-between fs-12 mb-1">
                                <span class="text-success">
                                    Active: {{ $activeUsers }}
                                </span>
                                <span class="text-danger">
                                    Inactive: {{ $inactiveUsers }}
                                </span>
                            </div>

                            <div class="progress mt-2 ht-3">
                                <div class="progress-bar bg-success" style="width: {{ $activePercentage }}%"></div>
                                <div class="progress-bar bg-danger" style="width: {{ 100 - $activePercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Users] end -->

            <!-- [Modules] start -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-grid"></i>
                            </div>
                            <h3 class="fs-13 fw-semibold mb-0">
                                Modules
                            </h3>
                        </div>

                        <div class="text-center mb-2">
                            <div class="fs-3 fw-bold text-dark">
                                {{ $moduleCount }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between fs-12 mb-1">
                            <span class="text-success">
                                Active: {{ $activeModules }}
                            </span>
                            <span class="text-danger">
                                Inactive: {{ $inactiveModules }}
                            </span>
                        </div>

                        <div class="progress mt-2 ht-3">
                            <div class="progress-bar bg-success" style="width: {{ $activeModulePercent }}%"></div>
                            <div class="progress-bar bg-danger" style="width: {{ 100 - $activeModulePercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [Modules] end -->

            <!-- [Role wise user] start -->
            <div class="col-xxl-6">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Role-wise User Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div id="role-wise-donut"></div>
                    </div>
                </div>
            </div>
            <!-- [Role wise user] end -->

            <!-- [Total hospitals] start -->
            <div class="col-xxl-6">
                <div class="card stretch stretch-full overflow-hidden">
                    <div class="bg-primary text-white p-4">
                        <span class="badge bg-light text-primary float-end">
                            {{ round($activeHospitalPercentage) }}%
                        </span>
                        <p class="text-reset m-0">Total Hospitals</p>
                    </div>

                    <div class="p-3">
                        <div id="hospitals-created-chart" style="height:250px;"></div>
                    </div>

                    <div class="card-footer text-center">
                        <span class="fw-bold text-uppercase text-muted">
                            View Hospitals
                        </span>
                    </div>
                </div>
            </div>
            <!-- [Total hospitals] end -->

            <!-- [Organization and Hospital growth chart] start -->
            <div class="col-xxl-13">
                <div class="card stretch stretch-full">
                    <div class="card-header">
                        <h5 class="card-title">Organizations & Hospitals Growth</h5>
                        <div class="card-header-action">
                            <div class="card-header-btn">
                                <div data-bs-toggle="tooltip" title="Delete">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger"
                                        data-bs-toggle="remove"></a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Refresh">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning"
                                        data-bs-toggle="refresh"></a>
                                </div>
                                <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                    <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                        data-bs-toggle="expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body custom-card-action p-0">
                        <div id="payment-records-chart"></div>
                    </div>
                </div>
            </div>
            <!-- [Organization and Hospital growth chart] end -->
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Org vs Hospitals bar chart --}}
    @if(isset($orgData) && isset($hospitalData))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var orgData = @json($orgData);
                var hospitalData = @json($hospitalData);

                var months = [];
                var orgCounts = [];
                var hospitalCounts = [];
                var allMonths = new Set();

                orgData.forEach(item => allMonths.add(item.month));
                hospitalData.forEach(item => allMonths.add(item.month));

                allMonths = Array.from(allMonths).sort();

                allMonths.forEach(function (month) {
                    months.push(month);
                    var org = orgData.find(o => o.month === month);
                    var hosp = hospitalData.find(h => h.month === month);
                    orgCounts.push(org ? org.count : 0);
                    hospitalCounts.push(hosp ? hosp.count : 0);
                });

                var options = {
                    chart: {
                        height: 380,
                        type: 'bar',
                        stacked: false,
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '35%',
                            borderRadius: 4
                        }
                    },
                    colors: ['#3454d1', '#E1E3EA'],
                    series: [
                        { name: 'Organizations', data: orgCounts },
                        { name: 'Hospitals', data: hospitalCounts }
                    ],
                    xaxis: {
                        categories: months,
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: {
                            style: {
                                fontSize: "12px",
                                colors: "#A0ACBB"
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: Math.max(...orgCounts, ...hospitalCounts),
                        forceNiceScale: true,
                        decimalsInFloat: 0,
                        labels: {
                            formatter: function (val) {
                                return Number.isInteger(val) ? val : '';
                            }
                        }
                    },
                    grid: {
                        borderColor: "#E1E3EA",
                        strokeDashArray: 4
                    },
                    dataLabels: { enabled: false },
                    legend: { position: 'bottom' }
                };

                new ApexCharts(
                    document.querySelector("#payment-records-chart"),
                    options
                ).render();
            });
        </script>
    @endif

    {{-- Role-wise donut --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var roleData = @json($roleWiseUsers);
            var roles = roleData.map(r => r.role_name);
            var counts = roleData.map(r => r.total);

            var options = {
                chart: {
                    type: 'donut',
                    height: 320
                },
                series: counts,
                labels: roles,
                colors: ['#3454d1', '#25b865', '#f4b400', '#d13b4c', '#6c757d'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                }
            };

            new ApexCharts(
                document.querySelector("#role-wise-donut"),
                options
            ).render();
        });
    </script>

    {{-- Hospitals created line chart --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var hospitalMonths = @json($hospitalMonths);
            var hospitalCounts = @json($hospitalCounts);

            console.log('DEBUG hospitals', hospitalMonths, hospitalCounts);

            var options = {
                chart: {
                    type: 'line',
                    height: 250,
                    toolbar: { show: false }
                },
                series: [{
                    name: "Hospitals Created",
                    data: hospitalCounts
                }],
                xaxis: {
                    categories: hospitalMonths
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#3454d1'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#hospitals-created-chart"),
                options
            ).render();
        });
    </script>
@endsection