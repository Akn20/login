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

        $weekends = $query->latest()->paginate(10)->withQueryString();

        $totalWeekends    = Weekends::count();
        $activeWeekends   = Weekends::where('status', 'active')->count();
        $inactiveWeekends = Weekends::where('status', 'inactive')->count();

        return view('admin.Leave_Management.Weekend.index', compact(
            'weekends',
            'totalWeekends',
            'activeWeekends',
            'inactiveWeekends'
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
            'details' => 'nullable|string',
            'status'  => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($data) {
            // Status logic: if new one is active, deactivate all others
            if ($data['status'] === 'active') {
                Weekends::where('status', 'active')->update(['status' => 'inactive']);
            }

            Weekends::create([
                'name'    => $data['name'],
                'days'    => $data['days'],
                'details' => $data['details'] ?? null,
                'status'  => $data['status'],
            ]);
        });

        return view('admin.Leave_Management.Weekend.index')
            
            ->with('success', 'Weekend configuration created successfully.');
    }

    public function show(string $id)
    {
        $weekend = Weekends::findOrFail($id);

        return view('admin.Leave_Management.Weekend.show', compact('weekend'));
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
            'name'    => 'required|string|max:255|unique:weekends,name,' . $weekend->id . ',id,deleted_at,NULL',
            'days'    => 'required|array|min:1',
            'days.*'  => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'details' => 'nullable|string',
            'status'  => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($data, $weekend) {
            if ($data['status'] === 'active') {
                Weekends::where('status', 'active')
                    ->where('id', '!=', $weekend->id)
                    ->update(['status' => 'inactive']);
            }

            $weekend->update([
                'name'    => $data['name'],
                'days'    => $data['days'],
                'details' => $data['details'] ?? null,
                'status'  => $data['status'],
            ]);
        });

        return redirect()
            ->route('admin.Leave_Management.Weekend.index')
            ->with('success', 'Weekend configuration updated successfully.');
    }

    public function destroy(string $id)
    {
        $weekend = Weekends::findOrFail($id);
        $weekend->delete();

        return redirect()
            ->route('admin.Leave_Management.Weekend.index')
            ->with('success', 'Weekend configuration moved to trash.');
    }

    public function deleted(Request $request)
    {
        $weekends = Weekends::onlyTrashed()->latest()->paginate(10);

        return view('admin.Leave_Management.Weekend.deleted', compact('weekends'));
    }

    public function restore(string $id)
    {
        $weekend = Weekends::onlyTrashed()->findOrFail($id);
        $weekend->restore();

        return redirect()
            ->route('admin.Leave_Management.Weekend.deleted')
            ->with('success', 'Weekend configuration restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $weekend = Weekends::onlyTrashed()->findOrFail($id);
        $weekend->forceDelete();

        return redirect()
            ->route('admin.Leave_Management.Weekend.deleted')
            ->with('success', 'Weekend configuration permanently deleted.');
    }

    public function toggleStatus(string $id, Request $request)
    {
        $weekend = Weekends::findOrFail($id);

        DB::transaction(function () use (&$weekend) {
            if ($weekend->status === 'active') {
                $weekend->status = 'inactive';
                $weekend->save();
            } else {
                Weekends::where('status', 'active')
                    ->where('id', '!=', $weekend->id)
                    ->update(['status' => 'inactive']);

                $weekend->status = 'active';
                $weekend->save();
            }
        });

        $totalWeekends    = Weekends::count();
        $activeWeekends   = Weekends::where('status', 'active')->count();
        $inactiveWeekends = Weekends::where('status', 'inactive')->count();

        if ($request->wantsJson()) {
            return response()->json([
                'success'          => true,
                'status'           => $weekend->status,
                'totalWeekends'    => $totalWeekends,
                'activeWeekends'   => $activeWeekends,
                'inactiveWeekends' => $inactiveWeekends,
            ]);
        }

        return back()->with('success', 'Status updated.');
    }
}
