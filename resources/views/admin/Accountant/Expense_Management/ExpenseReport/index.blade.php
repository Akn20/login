@extends('layouts.admin')

@section('page-title', 'Expense Report')

@section('content')

{{-- SUCCESS --}}
@if (session('success'))

<div class="alert alert-success alert-dismissible fade show">

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
    </button>

</div>

@endif


{{-- ================= HEADER ================= --}}
<div class="page-header mb-4 d-flex align-items-center justify-content-between">

    <div>

        <h5 class="m-0 mb-1">

            <i class="feather-file-text me-2"></i>

            Expense Report

        </h5>

        <ul class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                Accounts
            </li>

            <li class="breadcrumb-item">
                Expense Management
            </li>

            <li class="breadcrumb-item active">
                Expense Report
            </li>

        </ul>

    </div>

</div>


{{-- ================= CARD ================= --}}
<div class="card stretch stretch-full">

    <div class="card-body">

        <form method="GET"
              id="reportForm">

            <div class="row">

                {{-- REPORT TYPE --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Report Type
                    </label>

                    <select name="report_type"
                            id="report_type"
                            class="form-select">

                        <option value="category">
                            Category Wise Report
                        </option>

                        <option value="income_expense">
                            Income & Expense Report
                        </option>

                    </select>

                </div>


                {{-- FROM DATE --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        From Date
                    </label>

                    <input type="date"
                           name="from_date"
                           class="form-control">

                </div>


                {{-- TO DATE --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        To Date
                    </label>

                    <input type="date"
                           name="to_date"
                           class="form-control">

                </div>

            </div>


            {{-- CATEGORY REPORT FILTERS --}}
            <div class="row"
                 id="categoryFilters">

                {{-- EXPENSE CATEGORY --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Expense Category
                    </label>

                    <select name="category_id"
                            class="form-select">

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->category_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- VENDOR --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Vendor
                    </label>

                    <select name="vendor_id"
                            class="form-select">

                        <option value="">
                            Select Vendor
                        </option>

                        @foreach($vendors as $vendor)

                            <option value="{{ $vendor->id }}">

                                {{ $vendor->vendor_name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- PAYMENT STATUS --}}
                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Payment Status
                    </label>

                    <select name="payment_status"
                            class="form-select">

                        <option value="All">
                            All
                        </option>

                        <option value="Unpaid">
                            Unpaid
                        </option>

                        <option value="Partial">
                            Partial
                        </option>

                        <option value="Fully Paid">
                            Fully Paid
                        </option>

                    </select>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-3">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="feather-search me-1"></i>

                    Generate Report

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

    const reportType =
        document.getElementById('report_type');

    const categoryFilters =
        document.getElementById('categoryFilters');

    const reportForm =
        document.getElementById('reportForm');


    function toggleFilters()
    {
        if (reportType.value === 'income_expense')
        {
            categoryFilters.style.display = 'none';

            reportForm.action =
                "{{ route('admin.accountant.expense.report.income.expense') }}";
        }
        else
        {
            categoryFilters.style.display = 'flex';

            reportForm.action =
                "{{ route('admin.accountant.expense.report.category') }}";
        }
    }


    toggleFilters();

    reportType.addEventListener(
        'change',
        toggleFilters
    );

</script>

@endsection