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

        $modules = $query->get();

        return view('modules.index', compact('modules'));
    }
    // Show Create Module Form
    public function create()
    {
        $modules = Module::all(); // get existing modules
        return view('modules.create', compact('modules'));
    }

    //Store Module
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
            'access_for' => 'required|in:institution,service'

        ]);

        Module::create($request->all());

        return redirect()->route('modules.index')
            ->with('success', 'Module created successfully!');
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('modules.index')
            ->with('success', 'Module moved to trash.');
    }


    public function deleted()
    {
        $modules = Module::onlyTrashed()->get();
        return view('modules.deleted', compact('modules'));
    }

    public function restore($id)
    {
        Module::withTrashed()->find($id)->restore();

        return redirect()->route('modules.deleted')
            ->with('success', 'Module restored successfully.');
    }

    public function forceDelete($id)
    {
        Module::withTrashed()->find($id)->forceDelete();

        return redirect()->route('modules.deleted')
            ->with('success', 'Module permanently deleted.');
    }

    public function show($id)
    {
        $module = Module::findOrFail($id);
        return view('modules.show', compact('module'));
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $modules = Module::all(); // for parent dropdown

        return view('modules.edit', compact('module', 'modules'));
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
            'access_for' => 'required|in:institution,service'
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
            'access_for'
        ]));

        return redirect()->route('modules.index')
            ->with('success', 'Module updated successfully!');
    }


    public function toggleStatus($id)
    {
        $module = Module::findOrFail($id);

        $module->status = !$module->status;
        $module->save();

        return back();
    }




    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'data' => \App\Models\Module::latest()->get()
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'module_label' => 'required|string|max:100|unique:modules,module_label',
        ]);

        $module = \App\Models\Module::create($request->only([
            'module_label',
            'module_display_name',
            'parent_module',
            'priority',
            'icon',
            'file_url',
            'page_name',
            'type',
            'access_for'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Module created',
            'data' => $module
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $module = \App\Models\Module::findOrFail($id);
        $module->update($request->only([
            'module_label',
            'module_display_name',
            'parent_module',
            'priority',
            'icon',
            'file_url',
            'page_name',
            'type',
            'access_for'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Module updated'
        ]);
    }

    public function apiDelete($id)
    {
        $module = \App\Models\Module::findOrFail($id);
        $module->delete();

        return response()->json([
            'status' => true,
            'message' => 'Module deleted'
        ]);
    }
    public function apiShow($id)
    {
        $module = Module::findOrFail($id);
        return response()->json([
            'status' => true,
            'data' => $module
        ]);
    }
}