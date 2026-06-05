@extends('layouts.admin')

@section('page-title', 'Expense Voucher')

@section('content')

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

body{
    background: #fff !important;
    font-family: 'Poppins', sans-serif;
}

.voucher-wrapper{
    max-width: 950px;
    margin: 20px auto;
}

.voucher-box{
    border: 4px double #000;
    padding: 30px;
    background: #fff;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

.hospital-heading{
    font-family: 'Poppins', sans-serif;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #1e293b;
    margin-bottom: 20px;
    text-align: center;
}

.voucher-title{
    background: #43539c;
    color: #fff;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    letter-spacing: 2px;
    padding: 10px;
    width: 300px;
    margin: 20px auto 35px auto;
    font-size: 20px;
    border-radius: 4px;
}

.voucher-line{
    border-bottom: 2px solid #777;
    min-height: 32px;
    padding: 4px 8px;
}

.voucher-label{
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-style: italic;
    font-weight: 500;
    color: #333;
}

.voucher-value{
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #111;
}

.amount-box{
    border: 2px solid #333;
    width: 220px;
    padding: 10px;
    font-size: 18px;
    font-weight: 700;
}

.signature-text{
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-style: italic;
    font-weight: 500;
}

@media print {

    .btn,
    .nxl-navigation,
    .nxl-header,
    .theme-footer,
    .page-header,
    footer,
    footer *,
    .theme-footer *,
    .nxl-footer,
    .nxl-footer *{
        display: none !important;
    }

    html,
    body{
        background: #fff !important;
        height: auto !important;
        overflow: hidden !important;
    }

    .nxl-content,
    .main-content{
        margin: 0 !important;
        padding: 0 !important;
    }

    .voucher-wrapper{
        width: 100%;
        max-width: 100%;
    }

    .voucher-box{
        page-break-after: avoid !important;
        break-after: avoid !important;
        box-shadow: none !important;
    }

}

</style>

<div class="nxl-content">

    <div class="page-header mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h4 class="mb-1">
                Expense Voucher
            </h4>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.accountant.expense.add.index') }}"
                class="btn btn-light">

                Back

            </a>

            <button onclick="window.print()"
                class="btn btn-primary">

                Print Voucher

            </button>

        </div>

    </div>

    <div class="voucher-wrapper">

        <div class="voucher-box">

            {{-- HEADER --}}
            <div class="hospital-heading">
                Hospital Information Management System
            </div>

            {{-- TITLE --}}
            <div class="voucher-title">
                PAYMENT VOUCHER
            </div>

            {{-- TOP DETAILS --}}
            <div class="d-flex justify-content-between mb-4">

                <div class="voucher-value">

                    No:
                    {{ 'VCH-' . strtoupper(substr($expense->id, 0, 8)) }}

                </div>

                <div class="voucher-value">

                    Date:
                    {{ \Carbon\Carbon::parse($expense->payment_date)->format('d-m-Y') }}

                </div>

            </div>

            {{-- NAME --}}
            <div class="row mb-3">

                <div class="col-3 voucher-label">

                    Name

                </div>

                <div class="col-9 voucher-line voucher-value">

                    {{ $expense->vendor->vendor_name ?? 'General Vendor' }}

                </div>

            </div>

            {{-- AMOUNT --}}
            <div class="row mb-3">

                <div class="col-4 voucher-label">

                    Received the sum of Rs.

                </div>

                <div class="col-8 voucher-line voucher-value">

                    ₹{{ number_format($expense->paid_amount, 2) }}

                </div>

            </div>

            {{-- WORDS --}}
            <div class="row mb-4">

                <div class="col-12 voucher-line voucher-value">

                    {{ number_format($expense->paid_amount, 2) }} Only

                </div>

            </div>

            {{-- TOWARDS --}}
            <div class="row mb-4">

                <div class="col-2 voucher-label">

                    Towards

                </div>

                <div class="col-10 voucher-line voucher-value">

                    {{ $expense->expense_type }}

                </div>

            </div>

            {{-- PAYMENT MODE --}}
            <div class="mb-5 voucher-label">

                Through

                <span class="voucher-value">

                    {{ strtoupper($expense->payment_mode ?? '-') }}

                </span>

            </div>

            {{-- FOOTER --}}
            <div class="d-flex justify-content-between align-items-end mt-4">

                <div class="amount-box">

                    Rs.
                    {{ number_format($expense->paid_amount, 2) }}

                </div>

                <div class="signature-text">

                    Signature

                </div>

            </div>

        </div>

    </div>

</div>

@endsection