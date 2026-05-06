<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    /**
     * 🔹 INDEX
     */
    public function index()
    {
        $categories = ExpenseCategory::where('is_deleted', false)
                        ->latest()
                        ->get();

        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.index',
            compact('categories')
        );
    }

    /**
     * 🔹 CREATE PAGE
     */
    public function create()
    {
        return view('admin.Accountant.Expense_Management.ExpenseCategory.create');
    }

    /**
     * 🔹 STORE  ✅ FIXED VALIDATION
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'regex:/^[A-Za-z ]+$/', // ✅ prevent numbers like 123
                'max:150',
                'unique:expense_categories,category_name,NULL,id,is_deleted,0'
            ]
        ], [
            'category_name.regex' => 'Category name should contain only letters'
        ]);

        ExpenseCategory::create([
            'category_name' => $request->category_name,
            'is_deleted' => false,
        ]);

        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * 🔹 EDIT PAGE
     */
    public function edit($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.edit',
            compact('category')
        );
    }

    /**
     * 🔹 UPDATE  ✅ FIXED VALIDATION
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => [
                'required',
                'regex:/^[A-Za-z ]+$/', // ✅ prevent numbers
                'max:150',
                'unique:expense_categories,category_name,' . $id . ',id,is_deleted,0'
            ]
        ], [
            'category_name.regex' => 'Category name should contain only letters'
        ]);

        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * 🔹 DELETE (Soft Delete)
     */
    public function destroy($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'is_deleted' => true
        ]);

        return back()->with('success', 'Category deleted');
    }

    /**
     * 🔹 DELETED LIST
     */
    public function deleted()
    {
        $deleted = ExpenseCategory::where('is_deleted', true)
                    ->latest()
                    ->get();

        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.deleted',
            compact('deleted')
        );
    }

    /**
     * 🔹 RESTORE
     */
    public function restore($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'is_deleted' => false
        ]);

        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category restored successfully');
    }
}