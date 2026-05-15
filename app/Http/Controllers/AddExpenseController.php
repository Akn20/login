<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\InventoryVendor;
use App\Models\Expense;
use App\Models\ExpenseItem;
use Illuminate\Support\Str;

class AddExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with([
                            'category',
                            'vendor'
                        ])
                        ->latest()
                        ->get();

        return view(
            'admin.Accountant.Expense_Management.AddExpense.index',
            compact('expenses')
        );
    }

    public function create()
    {
        $categories = ExpenseCategory::where('is_deleted', false)
                        ->orderBy('category_name')
                        ->get();

        $vendors = InventoryVendor::whereNull('deleted_at')
                        ->orderBy('vendor_name')
                        ->get();

        return view(
            'admin.Accountant.Expense_Management.AddExpense.create',
            compact('categories', 'vendors')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'entry_date'      => 'required|date',

            'category_id'     => 'required|exists:expense_categories,id',

            'vendor_id'       => 'nullable|exists:inventory_vendors,id',

            'expense_type'    => 'required|string|max:150',

            'invoice_date'    => 'nullable|date',

            'invoice_number'  => 'nullable|string|max:150',

            'payment_status'  => 'required',

            'payment_mode'    => 'nullable',

            'payment_date'    => 'nullable|date',

            'paid_amount'     => 'nullable|numeric',

            'transaction_id'  => 'nullable|string|max:255',
        ]);

        // Calculate Grand Total
        $calculatedGrandTotal = array_sum($request->total ?? []);

        // Partial Payment Validation
        if (
            $request->payment_status == 'Partial' &&
            empty($request->paid_amount)
        ) {

            return back()
                ->withErrors([
                    'paid_amount' => 'Paid Amount is required for Partial Payment.'
                ])
                ->withInput();
        }

        // Fully Paid Validation
        if (
            $request->payment_status == 'Fully Paid' &&
            $request->paid_amount < $calculatedGrandTotal
        ) {

            return back()
                ->withErrors([
                    'paid_amount' => 'Paid Amount must match Grand Total.'
                ])
                ->withInput();
        }

        // Payment Date Validation
        if (
            in_array($request->payment_status, ['Partial', 'Fully Paid']) &&
            empty($request->payment_date)
        ) {

            return back()
                ->withErrors([
                    'payment_date' => 'Payment Date is required.'
                ])
                ->withInput();
        }

        // Transaction ID Validation
        if (
            in_array($request->payment_mode, ['Online', 'UPI']) &&
            empty($request->transaction_id)
        ) {

            return back()
                ->withErrors([
                    'transaction_id' => 'Transaction ID is required.'
                ])
                ->withInput();
        }

        // Auto Convert To Fully Paid
        if (
            $request->paid_amount >= $calculatedGrandTotal &&
            $calculatedGrandTotal > 0
        ) {

            $paymentStatus = 'Fully Paid';

        } else {

            $paymentStatus = $request->payment_status;
        }

        // Save Main Expense
        $expense = Expense::create([

            'id' => Str::uuid(),

            'entry_date' => $request->entry_date,

            'category_id' => $request->category_id,

            'vendor_id' => $request->vendor_id,

            'expense_type' => $request->expense_type,

            'invoice_date' => $request->invoice_date,

            'invoice_number' => $request->invoice_number,

            'grand_total' => 0,

            'payment_status' => $paymentStatus,

            'payment_mode' => $request->payment_mode,

            'payment_date' => $request->payment_date,

            'paid_amount' => $request->paid_amount,

            'transaction_id' => $request->transaction_id,
        ]);

        // Save Expense Items
        $grandTotal = 0;

        if ($request->expense_heading) {

            foreach ($request->expense_heading as $key => $heading) {

                if (!empty($heading)) {

                    $itemTotal = $request->total[$key] ?? 0;

                    ExpenseItem::create([

                        'id' => Str::uuid(),

                        'expense_id' => $expense->id,

                        'expense_heading' => $heading,

                        'unit' => $request->unit[$key] ?? 1,

                        'unit_price' => $request->unit_price[$key] ?? 0,

                        'sub_total' => $request->sub_total[$key] ?? 0,

                        'cgst' => $request->cgst[$key] ?? 0,

                        'sgst' => $request->sgst[$key] ?? 0,

                        'igst' => $request->igst[$key] ?? 0,

                        'total' => $itemTotal,
                    ]);

                    $grandTotal += $itemTotal;
                }
            }
        }

        // Update Grand Total
        $expense->update([
            'grand_total' => $grandTotal
        ]);

        return redirect()
            ->route('admin.accountant.expense.add.index')
            ->with('success', 'Expense Added Successfully');
    }

    public function show($id)
    {
        $expense = Expense::with([
                            'category',
                            'vendor',
                            'items'
                        ])
                        ->findOrFail($id);

        return view(
            'admin.Accountant.Expense_Management.AddExpense.show',
            compact('expense')
        );
    }

    public function edit($id)
    {
        $expense = Expense::with('items')
                        ->findOrFail($id);

        $categories = ExpenseCategory::where('is_deleted', false)
                        ->orderBy('category_name')
                        ->get();

        $vendors = InventoryVendor::whereNull('deleted_at')
                        ->orderBy('vendor_name')
                        ->get();

        return view(
            'admin.Accountant.Expense_Management.AddExpense.edit',
            compact(
                'expense',
                'categories',
                'vendors'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'entry_date'      => 'required|date',

            'category_id'     => 'required|exists:expense_categories,id',

            'vendor_id'       => 'nullable|exists:inventory_vendors,id',

            'expense_type'    => 'required|string|max:150',

            'invoice_date'    => 'nullable|date',

            'invoice_number'  => 'nullable|string|max:150',

            'payment_status'  => 'required',

            'payment_mode'    => 'nullable',

            'payment_date'    => 'nullable|date',

            'paid_amount'     => 'nullable|numeric|min:0',

            'transaction_id'  => 'nullable|string|max:255',
        ]);

        $expense = Expense::findOrFail($id);

        // Calculate Grand Total
        $calculatedGrandTotal = array_sum($request->total ?? []);

        // Previous Paid Amount
        $previousPaidAmount = $expense->paid_amount ?? 0;

        // New Entered Amount
        $newEnteredAmount = $request->paid_amount ?? 0;

        // Final Paid Amount
        $finalPaidAmount = $previousPaidAmount + $newEnteredAmount;


        // Prevent Over Payment
if ($finalPaidAmount > $calculatedGrandTotal) {

    return back()
        ->withErrors([
            'paid_amount' => 'Paid Amount cannot exceed Grand Total.'
        ])
        ->withInput();
}
        // Partial Payment Validation
        if (
            $request->payment_status == 'Partial' &&
            $newEnteredAmount <= 0
        ) {

            return back()
                ->withErrors([
                    'paid_amount' => 'Paid Amount is required for Partial Payment.'
                ])
                ->withInput();
        }

        // Payment Date Validation
        if (
            in_array($request->payment_status, ['Partial', 'Fully Paid']) &&
            empty($request->payment_date)
        ) {

            return back()
                ->withErrors([
                    'payment_date' => 'Payment Date is required.'
                ])
                ->withInput();
        }

        // Transaction ID Validation
        if (
            in_array($request->payment_mode, ['Online', 'UPI']) &&
            empty($request->transaction_id)
        ) {

            return back()
                ->withErrors([
                    'transaction_id' => 'Transaction ID is required.'
                ])
                ->withInput();
        }

        // Auto Convert To Fully Paid
        if (
            $finalPaidAmount >= $calculatedGrandTotal &&
            $calculatedGrandTotal > 0
        ) {

            $paymentStatus = 'Fully Paid';

            $finalPaidAmount = $calculatedGrandTotal;

        } else {

            $paymentStatus = 'Partial';
        }

        // Unpaid Condition
        if ($finalPaidAmount == 0) {

            $paymentStatus = 'Unpaid';
        }

        // Update Expense
        $expense->update([

            'entry_date' => $request->entry_date,

            'category_id' => $request->category_id,

            'vendor_id' => $request->vendor_id,

            'expense_type' => $request->expense_type,

            'invoice_date' => $request->invoice_date,

            'invoice_number' => $request->invoice_number,

            'payment_status' => $paymentStatus,

            'payment_mode' => $request->payment_mode,

            'payment_date' => $request->payment_date,

            'paid_amount' => $finalPaidAmount,

            'transaction_id' => $request->transaction_id,

            'grand_total' => $calculatedGrandTotal,
        ]);

        // Delete Old Items
        ExpenseItem::where('expense_id', $expense->id)->delete();

        // Reinsert Updated Items
        if ($request->expense_heading) {

            foreach ($request->expense_heading as $key => $heading) {

                if (!empty($heading)) {

                    ExpenseItem::create([

                        'id' => Str::uuid(),

                        'expense_id' => $expense->id,

                        'expense_heading' => $heading,

                        'unit' => $request->unit[$key] ?? 1,

                        'unit_price' => $request->unit_price[$key] ?? 0,

                        'sub_total' => $request->sub_total[$key] ?? 0,

                        'cgst' => $request->cgst[$key] ?? 0,

                        'sgst' => $request->sgst[$key] ?? 0,

                        'igst' => $request->igst[$key] ?? 0,

                        'total' => $request->total[$key] ?? 0,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.accountant.expense.add.index')
            ->with('success', 'Expense Updated Successfully');
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);

        $expense->delete();

        return redirect()
            ->route('admin.accountant.expense.add.index')
            ->with('success', 'Expense Deleted Successfully');
    }

    public function deleted()
    {
        $deletedExpenses = Expense::onlyTrashed()
                            ->with([
                                'category',
                                'vendor'
                            ])
                            ->latest()
                            ->get();

        return view(
            'admin.Accountant.Expense_Management.AddExpense.deleted',
            compact('deletedExpenses')
        );
    }

    public function restore($id)
    {
        $expense = Expense::withTrashed()->findOrFail($id);

        $expense->restore();

        return redirect()
            ->route('admin.accountant.expense.add.deleted')
            ->with('success', 'Expense Restored Successfully');
    }

    public function voucher($id)
    {
        $expense = Expense::with([
                            'category',
                            'vendor',
                            'items'
                        ])
                        ->findOrFail($id);

        return view(
            'admin.Accountant.Expense_Management.AddExpense.voucher',
            compact('expense')
        );
    }
}