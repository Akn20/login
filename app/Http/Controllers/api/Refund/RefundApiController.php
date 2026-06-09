<?php

namespace App\Http\Controllers\Api\Refund;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Refund;
use App\Models\RefundApproval;
use App\Models\RefundAuditLog;
use App\Models\RefundPayment;

use App\Models\Patient;
use App\Models\IpdBill;
use App\Models\SalesBill;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefundApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST REFUNDS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Refund::with('patient');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->patient) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->patient . '%')
                  ->orWhere('last_name', 'like', '%' . $request->patient . '%')
                  ->orWhere('patient_code', 'like', '%' . $request->patient . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->status) {

            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Refund Type
        |--------------------------------------------------------------------------
        */

        if ($request->refund_type) {

            $query->where(
                'refund_type',
                $request->refund_type
            );
        }

        $refunds = $query
            ->latest()
            ->paginate(10);

        return response()->json([

            'status' => true,
            'message' => 'Refund list fetched',
            'data' => $refunds
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE REFUND
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'patient_id' => 'required',

            'refund_type' => 'required',

            'refund_amount' => 'required|numeric|min:1',

            'refund_reason' => 'required',

            'refund_date' => 'required|date',
        ]);

        if ($validator->fails()) {

            return response()->json([

                'status' => false,

                'errors' => $validator->errors()

            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Check
        |--------------------------------------------------------------------------
        */

        $exists = Refund::where('bill_id', $request->bill_id)
            ->where('refund_amount', $request->refund_amount)
            ->whereIn('status', [
                'Pending',
                'Approved',
                'Processed'
            ])
            ->exists();

        if ($exists) {

            return response()->json([

                'status' => false,

                'message' =>
                    'Refund already exists'

            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | Eligibility Check
        |--------------------------------------------------------------------------
        */

        $error =
            $this->validateRefundEligibility($request);

        if ($error) {

            return response()->json([

                'status' => false,

                'message' => $error

            ], 400);
        }

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

    'status' => 'Pending',

    'requested_by' => auth()->id(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Audit Log
            |--------------------------------------------------------------------------
            */

            RefundAuditLog::create([

                'refund_id' => $refund->id,

                'action_type' => 'Created',

                'performed_by' => auth()->id(),

                'action_details' =>
                    'Refund created from API',
            ]);

            DB::commit();

            return response()->json([

                'status' => true,

                'message' =>
                    'Refund created successfully',

                'data' => $refund

            ]);
      } catch (\Exception $e) {

    DB::rollBack();

    return response()->json([

        'status' => false,

        'message' => $e->getMessage(),

        'line' => $e->getLine(),

        'file' => $e->getFile(),

    ], 500);
}
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW REFUND
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $refund = Refund::with([

            'patient',
            'approvals.user',
            'payments'
        ])->find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        return response()->json([

            'status' => true,

            'data' => $refund
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE REFUND
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Editing
        |--------------------------------------------------------------------------
        */

        if ($refund->status == 'Processed') {

            return response()->json([

                'status' => false,

                'message' =>
                    'Processed refund cannot edit'

            ], 400);
        }

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
        | Audit Log
        |--------------------------------------------------------------------------
        */

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Updated',

            'performed_by' => auth()->id(),

            'action_details' =>
                'Refund updated from API',
        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Refund updated successfully',

            'data' => $refund
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE REFUND
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $refund = Refund::find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Delete
        |--------------------------------------------------------------------------
        */

        if ($refund->status == 'Processed') {

            return response()->json([

                'status' => false,

                'message' =>
                    'Processed refund cannot delete'

            ], 400);
        }

        RefundAuditLog::create([

            'refund_id' => $refund->id,

            'action_type' => 'Deleted',

            'performed_by' => auth()->id(),

            'action_details' =>
                'Refund deleted from API',
        ]);

        $refund->delete();

        return response()->json([

            'status' => true,

            'message' =>
                'Refund deleted successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE REFUND
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $refund = Refund::find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        $refund->update([
            'status' => 'Approved'
        ]);

        RefundApproval::create([

            'refund_id' => $refund->id,

            'approved_by' => auth()->id(),

            'approval_status' => 'Approved',

            'approval_level' => 1,
        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Refund approved successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT REFUND
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        $refund->update([
            'status' => 'Rejected'
        ]);

        RefundApproval::create([

            'refund_id' => $refund->id,

            'approved_by' => auth()->id(),

            'approval_status' => 'Rejected',

            'comments' => $request->comments,

            'approval_level' => 1,
        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Refund rejected successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS PAYMENT
    |--------------------------------------------------------------------------
    */

    public function processPayment(Request $request, $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {

            return response()->json([

                'status' => false,

                'message' => 'Refund not found'

            ], 404);
        }

        if ($refund->status != 'Approved') {

            return response()->json([

                'status' => false,

                'message' =>
                    'Only approved refunds can process'

            ], 400);
        }

        $payment = RefundPayment::create([

            'refund_id' => $refund->id,

            'payment_mode' =>
                $request->payment_mode,

            'amount' =>
                $refund->refund_amount,

            'transaction_id' =>
                $request->transaction_id,

            'payment_date' => now(),

            'paid_by' => auth()->id(),
        ]);

        $refund->update([
            'status' => 'Processed'
        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Refund payment processed',

            'data' => $payment
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FETCH BILL DETAILS
    |--------------------------------------------------------------------------
    */

    public function fetchBillDetails(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | IPD
        |--------------------------------------------------------------------------
        */

        if ($request->bill_type == 'IPD') {

            $bill = IpdBill::with('patient')
                ->find($request->bill_id);

            if (!$bill) {

                return response()->json([
                    'status' => false
                ]);
            }

            return response()->json([

                'status' => true,

                'patient' =>
                    $bill->patient->first_name . ' ' .
                    $bill->patient->last_name,

                'paid_amount' =>
                    $bill->paid_amount,

                'due_amount' =>
                    $bill->due_amount,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PHARMACY
        |--------------------------------------------------------------------------
        */

        if ($request->bill_type == 'PHARMACY') {

            $bill = SalesBill::with('patient')
                ->find($request->bill_id);

            if (!$bill) {

                return response()->json([
                    'status' => false
                ]);
            }

            return response()->json([

                'status' => true,

                'patient' =>
                    $bill->display_patient_name,

                'paid_amount' =>
                    $bill->paid_amount,

                'due_amount' =>
                    $bill->balance_amount,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validateRefundEligibility(
        $request
    )
    {
        /*
        |--------------------------------------------------------------------------
        | IPD
        |--------------------------------------------------------------------------
        */

        if (
            $request->bill_type == 'IPD'
            &&
            $request->bill_id
        ) {

            $bill = IpdBill::find($request->bill_id);

            if (!$bill) {

                return 'Invalid IPD Bill';
            }

            if (
                $request->refund_amount >
                $bill->paid_amount
            ) {

                return
                    'Refund exceeds paid amount';
            }

            if ($bill->due_amount > 0) {

                return
                    'Cannot refund with pending dues';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PHARMACY
        |--------------------------------------------------------------------------
        */

        if (
            $request->bill_type == 'PHARMACY'
            &&
            $request->bill_id
        ) {

            $bill = SalesBill::find($request->bill_id);

            if (!$bill) {

                return
                    'Invalid pharmacy bill';
            }

            if (
                $request->refund_amount >
                $bill->paid_amount
            ) {

                return
                    'Refund exceeds paid amount';
            }
        }

        return null;
    }
}