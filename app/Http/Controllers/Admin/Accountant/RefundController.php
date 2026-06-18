<?php

namespace App\Http\Controllers\Admin\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Refund;
use App\Models\RefundAuditLog;
use App\Models\RefundApprovalLog;

use App\Models\Patient;
use App\Models\IpdBill;
use App\Models\SalesBill;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $refunds = Refund::with('patient')
            ->latest()
            ->paginate(10);

        return view(
            'admin.accountant.refunds.index',
            compact('refunds')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $patients = Patient::orderBy('first_name')
            ->get();

        return view(
            'admin.accountant.refunds.create',
            compact('patients')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'refund_type' => 'required',

            'refund_amount' => 'required|numeric|min:1',

            'refund_reason' => 'required',

            'refund_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Create Refund
            |--------------------------------------------------------------------------
            */

            $refund = Refund::create([

                'patient_id' => $request->patient_id,

                'bill_id' => $request->bill_id,

                'bill_type' => $request->bill_type,

                'refund_date' => $request->refund_date,

                'refund_type' => $request->refund_type,

                'refund_amount' => $request->refund_amount,

                'refund_reason' => $request->refund_reason,

                'remarks' => $request->remarks,

                'requested_by' => Auth::id(),

                'status' => 'Pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload Document
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('document')) {

                $file = $request->file('document');

                $path = $file->store(
                    'refund-documents',
                    'public'
                );

                $refund->update([
                    'document' => $path
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Audit Log
            |--------------------------------------------------------------------------
            */

            RefundAuditLog::create([

                'refund_id' => $refund->id,

                'action_type' => 'Created',

                'performed_by' => Auth::id(),

                'action_details' =>
                    'Refund request created',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.refunds.index')
                ->with(
                    'success',
                    'Refund request created successfully'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $refund = Refund::with([
            'patient',
            'approvalLogs.approver',
            'auditLogs.performedBy'
        ])->findOrFail($id);

        return view(
            'admin.accountant.refunds.show',
            compact('refund')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);

        $refund->update([

            'status' => 'Approved',

            'approved_by' => Auth::id(),

            'approved_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Approval Log
        |--------------------------------------------------------------------------
        */

        RefundApprovalLog::create([

            'refund_id' => $refund->id,

            'approver_id' => Auth::id(),

            'approval_status' => 'Approved',

            'remarks' => $request->remarks,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Approved',

            'performed_by' => Auth::id(),

            'action_details' =>
                'Refund approved',
        ]);

        return back()
            ->with(
                'success',
                'Refund approved successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);

        $refund->update([

            'status' => 'Rejected',
        ]);

        RefundApprovalLog::create([

            'refund_id' => $refund->id,

            'approver_id' => Auth::id(),

            'approval_status' => 'Rejected',

            'remarks' => $request->remarks,
        ]);

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Rejected',

            'performed_by' => Auth::id(),

            'action_details' =>
                'Refund rejected',
        ]);

        return back()
            ->with(
                'success',
                'Refund rejected successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS PAYMENT
    |--------------------------------------------------------------------------
    */

    public function processPayment(Request $request, $id)
    {
        $request->validate([

            'refund_mode' => 'required',

            'transaction_no' => 'nullable',
        ]);

        $refund = Refund::findOrFail($id);

        $refund->update([

            'refund_mode' => $request->refund_mode,

            'transaction_no' => $request->transaction_no,

            'status' => 'Processed',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Processed',

            'performed_by' => Auth::id(),

            'action_details' =>
                'Refund payment processed',
        ]);

        return back()
            ->with(
                'success',
                'Refund payment processed successfully'
            );
    }

    /*
|--------------------------------------------------------------------------
| RECEIPT
|--------------------------------------------------------------------------
*/

    public function receipt($id)
    {
        $refund = Refund::with('patient')
            ->findOrFail($id);

        return view(
            'admin.accountant.refunds.receipt',
            compact('refund')
        );
    }

    /*
|--------------------------------------------------------------------------
| EDIT
|--------------------------------------------------------------------------
*/

public function edit($id)
{
    $refund = Refund::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Prevent Editing After Processing
    |--------------------------------------------------------------------------
    */

    if ($refund->status == 'Processed') {

        return redirect()
            ->route('admin.refunds.index')
            ->with(
                'error',
                'Processed refunds cannot be edited'
            );
    }

    $patients = Patient::orderBy('first_name')
        ->get();

    return view(
        'admin.accountant.refunds.edit',
        compact(
            'refund',
            'patients'
        )
    );
}

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

public function update(Request $request, $id)
{
    $refund = Refund::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Prevent Editing After Processing
    |--------------------------------------------------------------------------
    */

    if ($refund->status == 'Processed') {

        return back()->with(
            'error',
            'Processed refunds cannot be edited'
        );
    }

    $request->validate([

        'patient_id' => 'required',

        'refund_type' => 'required',

        'refund_amount' => 'required|numeric|min:1',

        'refund_reason' => 'required',

        'refund_date' => 'required|date',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Eligibility Validation
    |--------------------------------------------------------------------------
    */

    $eligibilityError =
        $this->validateRefundEligibility($request);

    if ($eligibilityError) {

        return back()->with(
            'error',
            $eligibilityError
        );
    }

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Update Refund
        |--------------------------------------------------------------------------
        */

        $refund->update([

            'patient_id' => $request->patient_id,

            'bill_id' => $request->bill_id,

            'bill_type' => $request->bill_type,

            'refund_date' => $request->refund_date,

            'refund_type' => $request->refund_type,

            'refund_amount' => $request->refund_amount,

            'refund_reason' => $request->refund_reason,

            'remarks' => $request->remarks,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Document Upload
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('document')) {

            $file = $request->file('document');

            $path = $file->store(
                'refund-documents',
                'public'
            );

            $refund->update([
                'document' => $path
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Updated',

            'performed_by' => auth()->id(),

            'action_details' =>
                'Refund updated successfully',
        ]);

        DB::commit();

        return redirect()
            ->route('admin.refunds.index')
            ->with(
                'success',
                'Refund updated successfully'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}
/*
|--------------------------------------------------------------------------
| REFUND ELIGIBILITY VALIDATION
|--------------------------------------------------------------------------
*/

private function validateRefundEligibility($request)
{
    /*
    |--------------------------------------------------------------------------
    | IPD BILL VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $request->bill_type == 'IPD'
        &&
        $request->bill_id
    ) {

        $bill = IpdBill::find(
            $request->bill_id
        );

        if (!$bill) {

            return 'Invalid IPD Bill';
        }

        /*
        |--------------------------------------------------------------------------
        | Refund exceeds paid amount
        |--------------------------------------------------------------------------
        */

        if (
            $request->refund_amount >
            $bill->paid_amount
        ) {

            return 'Refund amount exceeds paid amount';
        }

        /*
        |--------------------------------------------------------------------------
        | Pending dues
        |--------------------------------------------------------------------------
        */

        if ($bill->due_amount > 0) {

            return 'Cannot refund while dues are pending';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PHARMACY BILL VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $request->bill_type == 'PHARMACY'
        &&
        $request->bill_id
    ) {

        $bill = SalesBill::find(
            $request->bill_id
        );

        if (!$bill) {

            return 'Invalid Pharmacy Bill';
        }

        if (
            $request->refund_amount >
            $bill->paid_amount
        ) {

            return 'Refund exceeds paid amount';
        }
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

public function destroy($id)
{
    $refund = Refund::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Prevent Delete After Processing
    |--------------------------------------------------------------------------
    */

    if ($refund->status == 'Processed') {

        return back()->with(
            'error',
            'Processed refunds cannot be deleted'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    RefundAuditLog::create([

        'refund_id' => $refund->id,

        'action_type' => 'Deleted',

        'performed_by' => auth()->id(),

        'action_details' =>
            'Refund deleted',
    ]);

    $refund->delete();

    return redirect()
        ->route('admin.refunds.index')
        ->with(
            'success',
            'Refund deleted successfully'
        );
}


}