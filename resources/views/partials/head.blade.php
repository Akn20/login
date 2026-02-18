<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="keyword" content="" />
<meta name="author" content="flexilecode" />

<title>Duralux || Dashboard</title>

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.co') }}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')  }}" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/daterangepicker.min.css') }}" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}" />


<style>
    .nxl-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .nxl-content {
        flex: 1;
    }

    .footer {
        margin-top: auto;
    }

    .btn-neutral {
        background: #f8f9fa;
        border: 1px solid #e2e2e2;
        color: #333;
        transition: all 0.2s ease;
    }

    .btn-neutral:hover {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .action-icon {
        border: 1px solid transparent;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    /* EDIT hover */
    .action-edit:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.08);
    }

    /* DELETE hover */
    .action-delete:hover {
        border-color: #dc3545;
        color: #dc3545;
        background: rgba(220, 53, 69, 0.08);
    }

    /* RESTORE hover */
    .action-restore:hover {
        border-color: #198754;
        color: #198754;
        background: rgba(25, 135, 84, 0.08);
    }
</style>