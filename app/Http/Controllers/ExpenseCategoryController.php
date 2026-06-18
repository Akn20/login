<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    /**
     * 🔹 INDEX
     */
    public function index(Request $request)
    {
        $categories = ExpenseCategory::where('is_deleted', false)
                        ->latest()
                        ->get();

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Expense categories retrieved successfully.',
                'data' => $categories,
            ], 200);
        }

        // Web Response
        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.index',
            compact('categories')
        );
    }

    /**
     * 🔹 CREATE PAGE
     */
    public function create(Request $request)
    {
        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Expense category create page.',
            ], 200);
        }

        // Web Response
        return view('admin.Accountant.Expense_Management.ExpenseCategory.create');
    }

    /**
     * 🔹 STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
                'max:150',
                'unique:expense_categories,category_name,NULL,id,is_deleted,0'
            ]
        ], [
            'category_name.regex' => 'Category name should contain only letters'
        ]);

        $category = ExpenseCategory::create([
            'category_name' => $request->category_name,
            'is_deleted' => false,
        ]);

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully.',
                'data' => $category,
            ], 201);
        }

        // Web Response
        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * 🔹 EDIT PAGE
     */
    public function edit(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Expense category retrieved successfully.',
                'data' => $category,
            ], 200);
        }

        // Web Response
        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.edit',
            compact('category')
        );
    }

    /**
     * 🔹 UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => [
                'required',
                'regex:/^[A-Za-z ]+$/',
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

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.',
                'data' => $category->fresh(),
            ], 200);
        }

        // Web Response
        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * 🔹 DELETE (Soft Delete)
     */
    public function destroy(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'is_deleted' => true
        ]);

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ], 200);
        }

        // Web Response
        return back()->with('success', 'Category deleted');
    }

    /**
     * 🔹 DELETED LIST
     */
    public function deleted(Request $request)
    {
        $deleted = ExpenseCategory::where('is_deleted', true)
                    ->latest()
                    ->get();

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted categories retrieved successfully.',
                'data' => $deleted,
            ], 200);
        }

        // Web Response
        return view(
            'admin.Accountant.Expense_Management.ExpenseCategory.deleted',
            compact('deleted')
        );
    }

    /**
     * 🔹 RESTORE
     */
    public function restore(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $category->update([
            'is_deleted' => false
        ]);

        // API Response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category restored successfully.',
                'data' => $category->fresh(),
            ], 200);
        }

        // Web Response
        return redirect()
            ->route('admin.accountant.expense.category.index')
            ->with('success', 'Category restored successfully');
    }
}