<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    // Show Module List
    public function index(Request $request)
    {
        $query = Module::orderBy('priority');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('module_label', 'like', "%$search%")
                    ->orWhere('module_display_name', 'like', "%$search%")
                    ->orWhere('file_url', 'like', "%$search%")
                    ->orWhere('page_name', 'like', "%$search%");
            });
        }
       // $modules = $query->with('parent')->get();
        $modules = $query->paginate(10);

        // Stats for cards (non-deleted only)
        $totalModules = Module::count();
        $activeModules = Module::where('status', 1)->count();
        $inactiveModules = Module::where('status', 0)->count();

        return view('admin.modules.index', compact(
            'modules',
            'totalModules',
            'activeModules',
            'inactiveModules'
        ));
    }

    // Show Create Module Form
    public function create()
    {
        $modules = Module::all(); // for parent dropdown

        return view('admin.modules.create', compact('modules'));
    }

    // Store Module
    public function store(Request $request)
    {
        $request->validate([
            'module_label' => 'required|string|max:100|unique:modules,module_label',
            'module_display_name' => 'required|string|max:150',
            'priority' => 'required|integer|min:1',
            'icon' => 'required|string|max:100',
            'file_url' => 'required|string|max:255',
            'page_name' => 'required|string|max:255',
            'type' => 'required|in:Web,App,Both',
            'access_for' => 'required|in:institution,service',
        ]);

        Module::create($request->all() + ['status' => 1]);

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module created successfully!');
    }

    // Soft delete
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module moved to trash.');
    }

    // List deleted modules
    public function deleted()
    {
        $modules = Module::onlyTrashed()->orderBy('priority')->get();

        return view('admin.modules.deleted', compact('modules'));
    }

    // Restore soft-deleted module
    public function restore($id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $module->restore();

        return redirect()
            ->route('admin.modules.deleted')
            ->with('success', 'Module restored successfully.');
    }

    // Permanently delete
    public function forceDelete($id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $module->forceDelete();

        return redirect()
            ->route('admin.modules.deleted')
            ->with('success', 'Module permanently deleted.');
    }

    public function show($id)
    {
        $module = Module::findOrFail($id);

        return view('admin.modules.show', compact('module'));
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $modules = Module::all(); // for parent dropdown

        return view('admin.modules.edit', compact('module', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'module_label' => [
                'required',
                'string',
                'max:100',
                Rule::unique('modules', 'module_label')->ignore($module->id),
            ],
            'module_display_name' => 'required|string|max:150',
            'priority' => 'required|integer|min:1',
            'icon' => 'required|string|max:100',
            'file_url' => 'required|string|max:255',
            'page_name' => 'required|string|max:255',
            'type' => 'required|in:Web,App,Both',
            'access_for' => 'required|in:institution,service',
        ]);

        $module->update($request->only([
            'module_label',
            'module_display_name',
            'parent_module',
            'priority',
            'icon',
            'file_url',
            'page_name',
            'type',
            'access_for',
        ]));

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module updated successfully!');
    }

    // Toggle status (WEB + AJAX)
    public function toggleStatus($id)
    {
        $module = Module::findOrFail($id);
        $module->status = ! $module->status;
        $module->save();

        $totalModules = Module::count();
        $activeModules = Module::where('status', 1)->count();
        $inactiveModules = Module::where('status', 0)->count();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $module->status ? 'active' : 'inactive',
                'is_active' => (bool) $module->status,
                'totalModules' => $totalModules,
                'activeModules' => $activeModules,
                'inactiveModules' => $inactiveModules,
            ]);
        }

        return back()->with('success', 'Status updated successfully');
    }   

    /* ===================== API ===================== */

    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'data' => Module::latest()->get(),
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'module_label' => 'required|string|max:100|unique:modules,module_label',
        ]);

        $module = Module::create($request->only([
            'module_label',
            'module_display_name',
            'parent_module',
            'priority',
            'icon',
            'file_url',
            'page_name',
            'type',
            'access_for',
        ]) + ['status' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Module created',
            'data' => $module,
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $module->update($request->only([
            'module_label',
            'module_display_name',
            'parent_module',
            'priority',
            'icon',
            'file_url',
            'page_name',
            'type',
            'access_for',
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Module updated',
        ]);
    }

    public function apiDelete($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return response()->json([
            'status' => true,
            'message' => 'Module deleted',
        ]);
    }

    public function apiShow($id)
    {
        $module = Module::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $module,
        ]);
    }

    // Module Api to get types
    public function getModuleTypes()
    {
        return response()->json([
            'success' => true,
            'data' => [
                ['value' => 'web',  'label' => 'Web'],
                ['value' => 'app',  'label' => 'App'],
                ['value' => 'both', 'label' => 'Both'],
            ],
        ]);
    }
}
