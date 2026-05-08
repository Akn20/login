{{-- resources/views/admin/accountant/revenue-management/index.blade.php --}}

@extends('layouts.admin')

@section('page-title', 'Revenue Management | ' . config('app.name'))
@section('title', 'Revenue Management')

@section('content')

<div class="main-content">
    <div class="row g-3">

        {{-- PAGE HEADER --}}
        <div class="col-12">
            <div class="page-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="m-b-10">
                        <i class="feather-bar-chart-2 me-2"></i>Revenue Management
                    </h5>
                </div>

                <div>
                  <a href="{{ route('admin.accountant.revenue.export') }}"
   class="btn btn-outline-primary btn-sm">
                        <i class="feather-download me-1"></i> Export
                    </a>
                </div>
            </div>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="col-md-3">
            <div class="card stretch stretch-full">
                <div class="card-body text-center">
                    <h6>Total Revenue</h6>
                    <h3 class="fw-bold text-success">
                        ₹ {{ number_format($totalRevenue, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stretch stretch-full">
                <div class="card-body text-center">
                    <h6>Today Revenue</h6>
                    <h3 class="fw-bold text-primary">
                        ₹ {{ number_format($todayRevenue, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stretch stretch-full">
                <div class="card-body text-center">
                    <h6>Monthly Revenue</h6>
                    <h3 class="fw-bold text-warning">
                        ₹ {{ number_format($monthlyRevenue, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stretch stretch-full">
                <div class="card-body text-center">
                    <h6>Annual Revenue</h6>
                    <h3 class="fw-bold text-danger">
                        ₹ {{ number_format($annualRevenue, 2) }}
                    </h3>
                </div>
            </div>
        </div>
{{-- REVENUE CHARTS --}}

<div class="col-md-6">
    <div class="card stretch stretch-full">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Department Revenue
            </h5>
        </div>

        <div class="card-body">
            <div id="department-revenue-chart"></div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card stretch stretch-full">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Doctor Revenue
            </h5>
        </div>

        <div class="card-body">
            <div id="doctor-revenue-chart"></div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card stretch stretch-full">
        <div class="card-header">
            <h5 class="card-title mb-0">
                Monthly Revenue Trend
            </h5>
        </div>

        <div class="card-body">
            <div id="monthly-revenue-chart"></div>
        </div>
    </div>
</div>

        {{-- FILTER SECTION --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h6 class="mb-3">Filters</h6>
                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <form method="GET">

                        <div class="row">

                            <div class="col-md-2 mb-3">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control"
                                       value="{{ request('from_date') }}">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control"
                                       value="{{ request('to_date') }}">
                            </div>

                          <div class="col-md-2 col-lg-2 mb-3">
                                <label>Department</label>
                            <select name="department" class="form-control">

    <option value="">All</option>

    @foreach($departments as $dept)
        <option value="{{ $dept->id }}"
            {{ request('department') == $dept->id ? 'selected' : '' }}>
            {{ $dept->department_name }}
        </option>
    @endforeach

</select>
                            </div>

                            <div class="col-md-2 col-lg-2 mb-3">
                                     <label>Doctor</label>
                                <select name="doctor" class="form-control">

    <option value="">All</option>

    @foreach($doctors as $doc)
        <option value="{{ $doc->id }}"
            {{ request('doctor') == $doc->id ? 'selected' : '' }}>
            {{ $doc->name }}
        </option>
    @endforeach

</select>
                            </div>

                  <div class="col-md-3 mb-3">
    <label>Service</label>

    <select name="service" class="form-select">

        <option value="">All</option>

        @foreach($services as $srv)
            <option value="{{ $srv->description }}"
                {{ request('service') == $srv->description ? 'selected' : '' }}>
                {{ $srv->description }}
            </option>
        @endforeach

    </select>
</div>

<div class="col-md-2 col-lg-2 mb-3">
    <label>Payment Mode</label>

    <select name="payment_mode" class="form-control">
        <option value="">All</option>

        <option value="cash"
            {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>
            Cash
        </option>

        <option value="card"
            {{ request('payment_mode') == 'card' ? 'selected' : '' }}>
            Card
        </option>

        <option value="upi"
            {{ request('payment_mode') == 'upi' ? 'selected' : '' }}>
            UPI
        </option>
    </select>
</div>

<!-- <div class="col-md-2 mb-3">
    <label>Group By</label>

    <select name="group_by" class="form-control">

        <option value="">None</option>

        <option value="department"
            {{ request('group_by') == 'department' ? 'selected' : '' }}>
            Department
        </option>

        <option value="doctor"
            {{ request('group_by') == 'doctor' ? 'selected' : '' }}>
            Doctor
        </option>

        <option value="service"
            {{ request('group_by') == 'service' ? 'selected' : '' }}>
            Service
        </option>

    </select>
</div> -->

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <button class="btn btn-primary btn-sm">
                                <i class="feather-filter me-1"></i> Apply
                            </button>

                            <a href="{{ route('admin.accountant.revenue.index') }}"
                               class="btn btn-secondary btn-sm">
                                <i class="feather-rotate-ccw me-1"></i> Reset
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>

     

        </div>

        {{-- TABLE --}}
        <div class="col-12">
    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered mb-0">

                    {{-- ✅ HEADINGS --}}
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Doctor</th>
                        <th>Service</th>
<th>Payment Mode</th>
<th class="text-end">Amount</th>
                        </tr>
                    </thead>

                    {{-- ✅ DATA --}}
                    <tbody>
                        @forelse($revenues as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                <td>{{ $item->department }}</td>
                                <td>{{ $item->doctor }}</td>
                            <td>
    @foreach(explode(',', $item->service) as $srv)
        <div>
            • {{ trim($srv) }}
        </div>
    @endforeach
</td>
                                <td>{{ $item->payment_mode ??'-' }}</td>
                                <td class="text-end">₹ {{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No revenue data found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{--  TOTAL --}}
                <tfoot>
    <tr>
        <th colspan="5" class="text-end">
            Total
        </th>

        <th class="text-end">
            ₹ {{ number_format($revenues->sum('amount'), 2) }}
        </th>
    </tr>
</tfoot>

                </table>

                    </div>

                </div>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="col-12 d-flex justify-content-end">

         {{ $revenues->links() }}

        </div>

    </div>
</div>

@endsection

@push('scripts')

{{-- Department Revenue Chart --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    var departmentNames = @json($departmentSummary->pluck('department'));
    var departmentRevenue = @json($departmentSummary->pluck('revenue'));
var options = {
    chart: {
        type: 'bar',
        height: 320,
        toolbar: {
            show: false
        }
    },

    plotOptions: {
        bar: {
            horizontal: true
        }
    },

    series: [{
        name: 'Revenue',
        data: departmentRevenue
    }],

    xaxis: {
        categories: departmentNames
    },

    dataLabels: {
        enabled: false
    },

    colors: ['#3454d1']
};

    new ApexCharts(
        document.querySelector("#department-revenue-chart"),
        options
    ).render();

});
</script>


{{-- Doctor Revenue Chart --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    var doctorNames = @json($doctorSummary->pluck('doctor'));

    var doctorRevenue = @json(
        $doctorSummary->pluck('revenue')->map(fn($r) => (float) $r)
    );

    var options = {
        chart: {
            type: 'donut',
            height: 320
        },

        series: doctorRevenue,

        labels: doctorNames,

        dataLabels: {
            enabled: true
        },

        legend: {
            position: 'bottom'
        },

        colors: [
         
           '#6f42c1',
            '#25b865',
            '#f4b400',
            '#d13b4c',
          
               '#3454d1',
        ]
    };

    new ApexCharts(
        document.querySelector("#doctor-revenue-chart"),
        options
    ).render();

});
</script>




{{-- Monthly Revenue Trend Chart --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    var months = @json($monthlyRevenueChart->pluck('month'));
    var revenues = @json($monthlyRevenueChart->pluck('revenue'));

    var options = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            }
        },

        series: [{
            name: 'Revenue',
            data: revenues
        }],

        xaxis: {
            categories: months
        },

        stroke: {
            curve: 'smooth',
            width: 3
        },

        dataLabels: {
            enabled: false
        },

        markers: {
            size: 5
        },

        colors: ['#28a745']
    };

    new ApexCharts(
        document.querySelector("#monthly-revenue-chart"),
        options
    ).render();

});
</script>

@endpush