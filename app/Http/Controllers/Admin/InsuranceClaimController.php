<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceClaim;
use App\Models\ClaimApproval;
use App\Models\ClaimPayment;
use App\Models\ClaimReconciliation;
use App\Models\Patient;

class InsuranceClaimController extends Controller
{
    // 🔹 LIST
    public function index(Request $request)
    {
        $query = InsuranceClaim::with(['approval', 'payments', 'patient'])->latest();

        // Search
        if ($request->search) {
            $query->where('claim_number', 'like', "%{$request->search}%")
                  ->orWhere('insurance_provider', 'like', "%{$request->search}%");
        }

        $claims = $query->get();

        return view('admin.Accountant.InsuranceClaims.index', compact('claims'));
    }

    // CREATE PAGE
    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name')->get();

        return view('admin.Accountant.InsuranceClaims.create', compact('patients'));
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'insurance_provider' => 'required|string|max:255',
            'billed_amount' => 'required|numeric|min:0',
        ]);

        InsuranceClaim::create([
            'claim_number' => 'CLM-' . now()->timestamp,
            'patient_id' => $request->patient_id,
            'insurance_provider' => $request->insurance_provider,
            'billed_amount' => $request->billed_amount,
            'claim_date' => now(),
        ]);

        return redirect()->route('admin.accountant.claims.index')
            ->with('success', 'Claim created successfully');
    }

    // 🔹 EDIT
    public function edit($id)
    {
        $claim = InsuranceClaim::findOrFail($id);
        $patients = Patient::select('id', 'first_name', 'last_name')->get();

        return view('admin.Accountant.InsuranceClaims.edit', compact('claim', 'patients'));
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $claim = InsuranceClaim::findOrFail($id);

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'insurance_provider' => 'required|string|max:255',
            'billed_amount' => 'required|numeric|min:0',
        ]);

        $claim->update([
            'patient_id' => $request->patient_id,
            'insurance_provider' => $request->insurance_provider,
            'billed_amount' => $request->billed_amount,
        ]);

        return redirect()->route('admin.accountant.claims.index')
            ->with('success', 'Claim updated successfully');
    }

    // 🔹 VIEW
    public function view($id)
    {
        $claim = InsuranceClaim::with(['approval', 'payments', 'patient'])->findOrFail($id);

        return view('admin.Accountant.InsuranceClaims.view', compact('claim'));
    }

    // 🔹 APPROVAL
   public function storeApproval(Request $request)
{
    $request->validate([
        'claim_id' => 'required|exists:insurance_claims,id',
        'approved_amount' => 'required|numeric|min:0',
        'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
    ]);

    // Find existing record
    $approval = ClaimApproval::where('claim_id', $request->claim_id)->first();

    // Prepare data
    $data = [
        'claim_id' => $request->claim_id,
        'approved_amount' => $request->approved_amount,
        'approval_date' => now(),
    ];

    // File upload (FORCE SAVE)
    if ($request->hasFile('document')) {

        $file = $request->file('document');

        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('approvals', $filename, 'public');

        $data['document'] = $path;
    }

    // Save manually (instead of updateOrCreate)
    if ($approval) {
        $approval->update($data);
    } else {
        ClaimApproval::create($data);
    }

    // 🔁 Recalculate
    $this->autoReconcile($request, $request->claim_id);

    return back()->with('success', 'Approval saved with document');
}

    // 🔹 PAYMENT
   public function storePayment(Request $request)
{
    $request->validate([
        'claim_id' => 'required|exists:insurance_claims,id',
        'payment_amount' => 'required|numeric|min:0',
        'payment_mode' => 'nullable|string|max:100',
        'transaction_reference' => 'nullable|string|max:255',
    ]);

    ClaimPayment::create([
        'claim_id' => $request->claim_id,
        'payment_amount' => $request->payment_amount,
        'payment_date' => now(),
        'payment_mode' => $request->payment_mode,
        'transaction_reference' => $request->transaction_reference, // ✅ NEW
    ]);

    // auto reconcile
    $this->autoReconcile($request, $request->claim_id);

    return back()->with('success', 'Payment added successfully');
}

    public function destroy($id)
    {
        $claim = InsuranceClaim::findOrFail($id);
        $claim->delete();

        return redirect()->route('admin.accountant.claims.index')
            ->with('success', 'Claim deleted successfully');
    }

    public function restore($id)
    {
        $claim = InsuranceClaim::withTrashed()->findOrFail($id);
        $claim->restore();

        return redirect()->route('admin.accountant.claims.index')
            ->with('success', 'Claim restored successfully');
    }

    public function forceDelete($id)
    {
        $claim = InsuranceClaim::withTrashed()->findOrFail($id);
        $claim->forceDelete();

        return redirect()->route('admin.accountant.claims.deleted')
            ->with('success', 'Claim permanently deleted');
    }

    public function deleted()
    {
        $claims = InsuranceClaim::onlyTrashed()->with(['approval', 'payments', 'patient'])->paginate(10);
        return view('admin.Accountant.InsuranceClaims.deleted', compact('claims'));
    }

    public function reconcile($id)
    {
        $this->autoReconcile(request(), $id);
        return back()->with('success', 'Claim reconciled');
    }

    public function reports()
{
    $totalClaims = InsuranceClaim::count();

    $totalBilled = InsuranceClaim::sum('billed_amount');

    $totalApproved = ClaimApproval::sum('approved_amount');

    $totalPaid = ClaimPayment::sum('payment_amount');

    $pendingClaims = InsuranceClaim::where('status', 'pending')->count();

    $partialClaims = InsuranceClaim::where('status', 'partial')->count();

    $approvedClaims = InsuranceClaim::where('status', 'approved')->count();

    // discrepancy (difference ≠ 0)
    $discrepancies = ClaimReconciliation::where('difference_amount', '!=', 0)->count();


    $statusData = [
        'pending' => $pendingClaims,
        'partial' => $partialClaims,
        'approved' => $approvedClaims,
    ];

    $financialData = [
        'billed' => $totalBilled,
        'approved' => $totalApproved,
        'paid' => $totalPaid,
    ];

    return view('admin.Accountant.InsuranceClaims.reports', compact(
        'totalClaims',
        'totalBilled',
        'totalApproved',
        'totalPaid',
        'pendingClaims',
        'partialClaims',
        'approvedClaims',
        'discrepancies',
        'statusData',
        'financialData'
    ));
}

    // 🔹 RECONCILE
   private function autoReconcile(Request $request, $claimId)
{
    $claim = InsuranceClaim::with(['approval', 'payments'])->findOrFail($claimId);

    $approved = $claim->approval->approved_amount ?? 0;
    $paid = $claim->payments->sum('payment_amount');

    $difference = $approved - $paid;

    ClaimReconciliation::updateOrCreate(
        ['claim_id' => $claimId],
        [
            'difference_amount' => $difference,
            'is_reconciled' => $difference == 0,
            'remarks' => $request->remarks,
        ]
    );

   
    if (!$claim->approval) {
        $claim->status = 'pending';
    } elseif ($paid == 0) {
        $claim->status = 'pending';
    } elseif ($paid < $approved) {
        $claim->status = 'partial';
    } elseif ($paid == $approved) {
        $claim->status = 'approved';
    } else {
        $claim->status = 'partial';
    }

    $claim->save();
}

public function apiIndex(Request $request)
{
    $query = InsuranceClaim::with(['approval', 'payments', 'patient'])->latest();

    if ($request->search) {
        $query->where('claim_number', 'like', "%{$request->search}%")
              ->orWhere('insurance_provider', 'like', "%{$request->search}%");
    }

    return response()->json([
        'status' => true,
        'data' => $query->get()
    ]);
}

public function apiShow($id)
{
    $claim = InsuranceClaim::with(['approval', 'payments', 'patient'])
        ->findOrFail($id);

    return response()->json([
        'status' => true,
        'data' => $claim
    ]);
}

public function apiStore(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'insurance_provider' => 'required|string|max:255',
        'billed_amount' => 'required|numeric|min:0',
    ]);

    $claim = InsuranceClaim::create([
        'claim_number' => 'CLM-' . now()->timestamp,
        'patient_id' => $request->patient_id,
        'insurance_provider' => $request->insurance_provider,
        'billed_amount' => $request->billed_amount,
        'claim_date' => now(),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Claim created successfully',
        'data' => $claim
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $claim = InsuranceClaim::findOrFail($id);

    $claim->update([
        'patient_id' => $request->patient_id,
        'insurance_provider' => $request->insurance_provider,
        'billed_amount' => $request->billed_amount,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Claim updated successfully'
    ]);
}

public function apiDelete($id)
{
    $claim = InsuranceClaim::findOrFail($id);
    $claim->delete();

    return response()->json([
        'status' => true,
        'message' => 'Claim deleted'
    ]);
}

public function apiRestore($id)
{
    $claim = InsuranceClaim::withTrashed()->findOrFail($id);
    $claim->restore();

    return response()->json([
        'status' => true,
        'message' => 'Claim restored'
    ]);
}

public function apiForceDelete($id)
{
    $claim = InsuranceClaim::withTrashed()->findOrFail($id);
    $claim->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Claim permanently deleted'
    ]);
}

public function apiApproval(Request $request)
{
    $request->validate([
        'claim_id' => 'required|exists:insurance_claims,id',
        'approved_amount' => 'required|numeric|min:0',
    ]);

    ClaimApproval::updateOrCreate(
        ['claim_id' => $request->claim_id],
        [
            'approved_amount' => $request->approved_amount,
            'approval_date' => now()
        ]
    );

    $this->autoReconcile($request, $request->claim_id);

    return response()->json([
        'status' => true,
        'message' => 'Approval saved'
    ]);
}

public function apiPayment(Request $request)
{
    $request->validate([
        'claim_id' => 'required|exists:insurance_claims,id',
        'payment_amount' => 'required|numeric|min:0',
    ]);

    ClaimPayment::create([
        'claim_id' => $request->claim_id,
        'payment_amount' => $request->payment_amount,
        'payment_date' => now(),
    ]);

    $this->autoReconcile($request, $request->claim_id);

    return response()->json([
        'status' => true,
        'message' => 'Payment added'
    ]);
}

public function apiReports()
{
    return response()->json([
        'status' => true,
        'data' => [
            'total_claims' => InsuranceClaim::count(),
            'total_billed' => InsuranceClaim::sum('billed_amount'),
            'total_approved' => ClaimApproval::sum('approved_amount'),
            'total_paid' => ClaimPayment::sum('payment_amount'),
            'pending' => InsuranceClaim::where('status', 'pending')->count(),
            'partial' => InsuranceClaim::where('status', 'partial')->count(),
            'approved' => InsuranceClaim::where('status', 'approved')->count(),
            'discrepancies' => ClaimReconciliation::where('difference_amount', '!=', 0)->count()
        ]
    ]);
}


}