<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\PayrollDeduction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayrollDeductionController extends Controller
{
    // =========================
    // WEB METHODS
    // =========================

    public function index(Request $request)
    {
        $query = PayrollDeduction::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('display_name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('rule_set_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', strtoupper($request->status));
        }

        if ($request->filled('nature')) {
            $query->where('nature', strtoupper($request->nature));
        }

        $deductions = $query->orderBy('display_name')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $deductions,
            ]);
        }

        return view('hr.payroll.deduction.index', compact('deductions'));
    }

    public function create()
    {
        return view('hr.payroll.deduction.form');
    }

    public function show(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        return view('hr.payroll.deduction.show', compact('deduction'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        PayrollDeduction::create($data);

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction created successfully.');
    }

    public function edit(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        return view('hr.payroll.deduction.form', compact('deduction'));
    }

    public function update(Request $request, string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $data = $this->validateRequest($request, $deduction->id);

        $deduction->update($data);

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction updated successfully.');
    }

    public function destroy(string $id)
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $deduction->delete();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction deleted successfully.');
    }

    public function deleted()
    {
        $deductions = PayrollDeduction::onlyTrashed()->paginate(15);

        return view('hr.payroll.deduction.deleted', compact('deductions'));
    }

    public function restore(string $id)
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);

        $deduction->restore();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);

        $deduction->forceDelete();

        return redirect()
            ->route('hr.payroll.deduction.index')
            ->with('success', 'Deduction deleted successfully.');
    }

    // =========================
    // API METHODS
    // =========================

    public function apiIndex(Request $request): JsonResponse
    {
        $query = PayrollDeduction::query();

        if ($request->filled('type')) {
            $query->where('nature', strtoupper($request->type));
        }

        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }

        $deductions = $query
            ->orderBy('display_name')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->display_name,
                    'code' => $item->name,
                    'subtitle' => $item->description ?: ($item->category === 'RECURRING' ? 'Recurring deduction' : 'One-time deduction'),
                    'status' => $item->status,
                    'type' => $item->nature,
                    'category' => $item->category,
                    'description' => $item->description,
                    'lop_impact' => $item->lop_impact,
                    'prorata_applicable' => $item->prorata_applicable,
                    'tax_deductible' => $item->tax_deductible,
                    'pf_impact' => $item->pf_impact,
                    'esi_impact' => $item->esi_impact,
                    'pt_impact' => $item->pt_impact,
                    'rule_set_code' => $item->rule_set_code,
                    'show_in_payslip' => $item->show_in_payslip,
                    'payslip_order' => $item->payslip_order,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Deductions fetched successfully.',
            'data' => $deductions,
        ], 200);
    }

    public function apiShow(string $id): JsonResponse
    {
        $item = PayrollDeduction::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Deduction fetched successfully.',
            'data' => $item,
        ], 200);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $data = $this->validateRequest($request);

        $deduction = PayrollDeduction::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Deduction created successfully.',
            'data' => $deduction,
        ], 201);
    }

    public function apiUpdate(Request $request, string $id): JsonResponse
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $data = $this->validateRequest($request, $deduction->id);

        $deduction->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Deduction updated successfully.',
            'data' => $deduction->fresh(),
        ], 200);
    }

    public function apiDestroy(string $id): JsonResponse
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $deduction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deduction deleted successfully.',
        ], 200);
    }

    public function apiDeleted(Request $request): JsonResponse
    {
        $query = PayrollDeduction::onlyTrashed();

        if ($request->filled('type')) {
            $query->where('nature', strtoupper($request->type));
        }

        $deductions = $query
            ->orderBy('display_name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Deleted deductions fetched successfully.',
            'data' => $deductions,
        ], 200);
    }

    public function apiRestore(string $id): JsonResponse
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);

        $deduction->restore();

        return response()->json([
            'success' => true,
            'message' => 'Deduction restored successfully.',
        ], 200);
    }

    public function apiForceDelete(string $id): JsonResponse
    {
        $deduction = PayrollDeduction::onlyTrashed()->findOrFail($id);
        $deduction->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Deduction permanently deleted successfully.',
        ], 200);
    }

    public function apiToggleStatus(Request $request, string $id): JsonResponse
    {
        $deduction = PayrollDeduction::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);

        $deduction->status = $validated['status'];
        $deduction->save();

        return response()->json([
            'success' => true,
            'message' => 'Deduction status updated successfully.',
            'data' => $deduction->fresh(),
        ], 200);
    }

    // =========================
    // SHARED VALIDATION
    // =========================

    protected function validateRequest(Request $request, ?string $id = null): array
    {
        $nameRule = 'required|string|max:255|unique:deductions,name';
        if ($id) {
            $nameRule .= ','.$id.',id';
        }

        return $request->validate([
            'name' => $nameRule,
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'nature' => ['required', 'in:FIXED,VARIABLE'],
            'category' => ['required', 'in:RECURRING,ADHOC'],
            'lop_impact' => ['required', 'in:YES,NO'],
            'prorata_applicable' => ['required', 'in:YES,NO'],
            'tax_deductible' => ['required', 'in:YES,NO'],
            'pf_impact' => ['required', 'in:YES,NO'],
            'esi_impact' => ['required', 'in:YES,NO'],
            'pt_impact' => ['required', 'in:YES,NO'],
            'rule_set_code' => ['nullable', 'string', 'max:255'],
            'show_in_payslip' => ['required', 'in:YES,NO'],
            'payslip_order' => ['nullable', 'integer'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);
    }
}
