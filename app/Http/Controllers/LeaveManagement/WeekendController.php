<?php
namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\Weekends;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeekendController extends Controller
{
    public function index(Request $request)
    {
        $query = Weekends::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $weekends = $query->latest()->paginate(10);

        if(request()->wantsJson()) {
            $weekends = $query->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $weekends,
            ]);
        }
        return view('admin.Leave_Management.Weekend.index', compact(
            'weekends',
        ));
    }

    public function create()
    {
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

        return view('admin.Leave_Management.Weekend.create', compact('days'));
    }

    public function store(Request $request)
    {
        // Inline validation
        $data = $request->validate([
            'name'    => 'required|string|max:255|unique:weekends,name,NULL,id,deleted_at,NULL',
            'days'    => 'required|array|min:1',
            'days.*'  => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'status'  => 'required|in:active,inactive',
        ]);


            Weekends::create([
                'name'    => $data['name'],
                'days'    => $data['days'],
                'status'  => $data['status'],
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Weekend configuration created successfully.',
                    'data'    => $data,
                ], 201);
            }
        return redirect()
        ->route('admin.weekends.index')
        ->with('success', 'Weekend configuration created successfully.');
    }


    public function edit(string $id)
    {
        $weekend = Weekends::findOrFail($id);
        $days    = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

        return view('admin.Leave_Management.Weekend.edit', compact('weekend', 'days'));
    }

    public function update(Request $request, string $id)
{
    $weekend = Weekends::findOrFail($id);

    // Inline validation for update (ignore current record in unique rule)
    $data = $request->validate([
        'name'   => 'sometimes|required|string|max:255|unique:weekends,name,' . $weekend->id . ',id,deleted_at,NULL',
        'days'   => 'required|array|min:1',
        'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        'status' => 'required|in:active,inactive',
    ]);

    DB::transaction(function () use ($data, $weekend) {
        $weekend->update($data);
    });

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Weekend configuration updated successfully.',
            'data'    => $data,
        ]);
    }

    return redirect()
        ->route('admin.weekends.index')
        ->with('success', 'Weekend configuration updated successfully.');
}


    public function destroy( string $id)
    {
        $weekend = Weekends::findOrFail($id);
        $weekend->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Weekend configuration moved to trash.',
            ]);
        }

        return redirect()
            ->route('admin.weekends.index')
            ->with('success', 'Weekend configuration moved to trash.');
    }

    public function deleted(Request $request)
    {
        $weekends = Weekends::onlyTrashed()->latest()->paginate(10);

        if (request()->wantsJson()) {
            $weekends = Weekends::onlyTrashed()->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $weekends
            ]); 
        }

        return view('admin.Leave_Management.Weekend.deleted', compact('weekends'));
    }

    public function restore(Request $request, string $id)
    {
        $weekend = Weekends::onlyTrashed()->findOrFail($id);
        $weekend->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Weekend configuration restored successfully.',
            ]);
        }

        return redirect()
            ->route('admin.weekends.deleted')
            ->with('success', 'Weekend configuration restored successfully.');
    }

    public function forceDelete(Request $request,  string $id)
    {
        $weekend = Weekends::onlyTrashed()->findOrFail($id);
        $weekend->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Weekend configuration permanently deleted.',
            ]);
        }

        return redirect()
            ->route('admin.weekends.deleted')
            ->with('success', 'Weekend configuration permanently deleted.');
    }

  public function toggleStatus(string $id, Request $request)
{
    $weekend = Weekends::findOrFail($id);

    // If using enum/string: 'active' / 'inactive'
    $weekend->status = $weekend->status === 'active' ? 'inactive' : 'active';
    $weekend->save();

    if (request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'status'  => $weekend->status,
        ]);
    }

    return back();
}

}
