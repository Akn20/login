<?php

namespace App\Http\Controllers\doctor\surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Support\Str;
use App\Models\PreOperative;
use App\Models\PostOperative;

class SurgeryController extends Controller
{

    // List all surgeries
    public function index()
    {
        $surgeries = Surgery::with('patient', 'surgeon')->latest()->get();

        // Check which surgeries have postoperative records
        $surgeriesWithPostOp = PostOperative::pluck('surgery_id')->toArray();

        return view('doctor.surgery.schedule.index', compact('surgeries', 'surgeriesWithPostOp'));
    }

    // Show create page
    public function create()
{
    $patients = Patient::all();

    $surgeons = Staff::whereHas('designation', function($q){
        $q->where('designation_name','Surgeon');
    })->get();

    $assistantDoctors = Staff::whereHas('designation', function($q){
        $q->where('designation_name','Doctor');
    })->get();

    $anesthetists = Staff::whereHas('designation', function($q){
        $q->where('designation_name','Anesthetist');
    })->get();

    return view('doctor.surgery.schedule.create', compact(
        'patients',
        'surgeons',
        'assistantDoctors',
        'anesthetists'
    ));
}
    public function edit($id)
    {

        $surgery = Surgery::findOrFail($id);

        $preoperative = PreOperative::where('surgery_id',$id)->first();

        $patients = Patient::all();

        $doctors = Staff::all();

        return view('doctor.surgery.schedule.edit',compact(
            'surgery',
            'preoperative',
            'patients',
            'doctors'
        ));

    }

    public function update(Request $request,$id)
{

    $surgery = Surgery::findOrFail($id);

    $surgery->update([

        'patient_id'=>$request->patient_id,
        'surgery_type'=>$request->surgery_type,
        'surgery_date'=>$request->surgery_date,
        'surgery_time'=>$request->surgery_time,
        'ot_room'=>$request->ot_room

    ]);


    PreOperative::updateOrCreate(

        ['surgery_id'=>$id],

        [
            'bp'=>$request->bp,
            'heart_rate'=>$request->heart_rate,
            'fasting_status'=>$request->fasting_status
        ]

    );


    return redirect()->route('surgery.index')
        ->with('success','Surgery Updated Successfully');

}
    public function destroy($id)
{

    $surgery = Surgery::findOrFail($id);

    // delete related pre-operative notes
    PreOperative::where('surgery_id',$id)->delete();

    $surgery->delete();

    return redirect()->route('surgery.index')
        ->with('success','Surgery Deleted Successfully');

}
    // Store surgery
    public function store(Request $request)
{

    $surgery = Surgery::create([

        'id' => Str::uuid(),

        'patient_id'=>$request->patient_id,
        'surgery_type'=>$request->surgery_type,
        'surgery_date'=>$request->surgery_date,
        'surgery_time'=>$request->surgery_time,
        'ot_room'=>$request->ot_room,
        'surgeon_id'=>$request->surgeon_id,
        'assistant_doctor_id'=>$request->assistant_doctor_id,
        'anesthetist_id'=>$request->anesthetist_id,
        'priority'=>$request->priority,
        'notes'=>$request->notes

    ]);


    PreOperative::create([

        'surgery_id'=>$surgery->id,

        'bp'=>$request->bp,

        'heart_rate'=>$request->heart_rate,

        'allergies'=>$request->allergies,

        'consent_obtained'=>$request->consent_obtained,

        'fasting_status'=>$request->fasting_status,

        'instructions'=>$request->instructions,

        'risk_factors'=>$request->risk_factors

    ]);


    return redirect()->route('surgery.index')
        ->with('success','Surgery Scheduled Successfully');

}
}