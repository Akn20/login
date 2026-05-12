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

            'payment_status' => $request->payment_status,

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

    public function edit($id)
    {
        return view('admin.Accountant.Expense_Management.AddExpense.edit');
    }

    public function deleted()
    {
        return view('admin.Accountant.Expense_Management.AddExpense.deleted');
    }
}