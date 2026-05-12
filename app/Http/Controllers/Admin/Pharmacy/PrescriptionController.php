<?php
 
namespace App\Http\Controllers\Admin\Pharmacy;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OfflinePrescription;
use App\Models\OfflinePrescriptionItem;
use App\Models\SalesBillItem;
use Illuminate\Support\Str;
use App\Models\Prescription;
 
class PrescriptionController extends Controller
{
 
/* ================= PRESCRIPTION LIST ================= */
 
public function index(Request $request)
{
 
// DIGITAL PRESCRIPTIONS
$digital = DB::table('consultations')
    ->join('patients','patients.id','=','consultations.patient_id')
    ->join('staff','staff.id','=','consultations.doctor_id')
 
    ->leftJoin(DB::raw('(SELECT consultation_id, status
                         FROM prescription_status
                         ORDER BY created_at DESC) as ps'),
               'consultations.id','=','ps.consultation_id')
 
    ->select(
        'consultations.id',
 
        DB::raw("CONCAT('PR-',LPAD(consultations.id,4,'0')) as prescription_number"),
 
        DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
 
        'staff.name as doctor_name',
 
        'consultations.consultation_date as prescription_date',
 
        DB::raw("'Digital' as prescription_type"),
 
        DB::raw("COALESCE(ps.status,'Pending') as status")
    )
    ->get();
 
 
    // OFFLINE PRESCRIPTIONS
    $offline = DB::table('offline_prescriptions')
    ->select(
    
    'id',
    
    'prescription_number',
    
    'patient_name',
    
    'doctor_name',
    
    'prescription_date',
    
    DB::raw("'Offline' as prescription_type"),
    
    'status'
    
    )
    ->get();

    //IPD 
 $ipd = DB::table('ipd_prescriptions')
    ->leftJoin('patients','patients.id','=','ipd_prescriptions.patient_id')
    ->leftJoin('staff','staff.id','=','ipd_prescriptions.doctor_id')
    ->select(
        'ipd_prescriptions.id',
        DB::raw("CONCAT('IPD-', SUBSTRING(ipd_prescriptions.id,1,4)) as prescription_number"),
        DB::raw("CONCAT(COALESCE(patients.first_name,''),' ',COALESCE(patients.last_name,'')) as patient_name"),
        DB::raw("COALESCE(staff.name,'IPD Doctor') as doctor_name"),
        'ipd_prescriptions.prescription_date',
        DB::raw("'IPD' as prescription_type"),
        DB::raw("COALESCE(ipd_prescriptions.status,'Pending') as status")
    )
    ->get();
 
    // MERGE BOTH
   $prescriptions = $digital
    ->merge($offline)
    ->merge($ipd)
    ->sortByDesc('prescription_date')
    ->values();
 
 
/* ---------- APPLY FILTERS ---------- */
 
if($request->patient_name){
    $prescriptions = $prescriptions->filter(function($item) use ($request){
        return stripos($item->patient_name,$request->patient_name) !== false;
    });
}
 
if($request->doctor_name){
    $prescriptions = $prescriptions->filter(function($item) use ($request){
        return stripos($item->doctor_name,$request->doctor_name) !== false;
    });
}
 
if($request->status){
    $prescriptions = $prescriptions->filter(function($item) use ($request){
        return $item->status == $request->status;
    });
}
 
 
return view(
'admin.pharmacy.prescriptions.index',
compact('prescriptions')
);
 
}
 
 
 
/* ================= SHOW PRESCRIPTION ================= */
 
public function show($id)
{
   
/* ---------- CHECK OFFLINE PRESCRIPTION ---------- */
 
    $offline = OfflinePrescription::where('id',$id)->first();
    
    if($offline){
    
        $items = DB::table('offline_prescription_items')
            ->where('offline_prescription_id',$id)
            ->get();
    
        $prescription = (object)[
    
            'id'=>$offline->id,
    
            'patient_name'=>$offline->patient_name,
    
            'patient_phone'=>$offline->patient_phone,
    
            'patient_gender'=>null,
    
            'doctor_name'=>$offline->doctor_name,
    
            'doctor_department'=>null,
    
            'prescription_date'=>$offline->prescription_date,
    
            'prescription_type'=>'Offline',
    
            'status'=>$offline->status,
    
            'uploaded_prescription'=>$offline->uploaded_prescription,
    
            'items'=>$items
        ];
    
        return view('admin.pharmacy.prescriptions.show',compact('prescription'));
    }

/* ---------- CHECK IPD PRESCRIPTION ---------- */

$ipd = DB::table('ipd_prescriptions')
    ->leftJoin('patients','patients.id','=','ipd_prescriptions.patient_id')
    ->leftJoin('staff','staff.id','=','ipd_prescriptions.doctor_id')
    ->where('ipd_prescriptions.id',$id)
    ->select(
        'ipd_prescriptions.id',
        'ipd_prescriptions.prescription_date',
        DB::raw("CONCAT(COALESCE(patients.first_name,''),' ',COALESCE(patients.last_name,'')) as patient_name"),
        DB::raw("COALESCE(patients.mobile,'-') as patient_phone"),
        DB::raw("COALESCE(patients.gender,'-') as patient_gender"),
        DB::raw("COALESCE(staff.name,'IPD Doctor') as doctor_name")
    )
    ->first();

if($ipd){

    $items = DB::table('ipd_prescription_items')
        ->where('prescription_id',$id)
        ->get();

    $prescription = (object)[
        'id' => $ipd->id,
        'patient_name' => $ipd->patient_name,
        'patient_phone' => $ipd->patient_phone,
        'patient_gender' => $ipd->patient_gender,
        'doctor_name' => $ipd->doctor_name,
        'doctor_department' => 'IPD',
        'prescription_date' => $ipd->prescription_date,
        'prescription_type' => 'IPD',
        'status' => 'Pending',
        'items' => $items
    ];

    return view('admin.pharmacy.prescriptions.show', compact('prescription'));
}
 
 
/* ---------- DIGITAL PRESCRIPTION ---------- */
 
$consultation = DB::table('consultations')
 
    ->join('patients','consultations.patient_id','=','patients.id')
 
    ->join('staff','consultations.doctor_id','=','staff.id')
 
    ->leftJoin('department_master','department_master.id','=','staff.department_id')
 
    ->where('consultations.id',$id)
 
    ->select(
 
        'consultations.id',
 
        'consultations.consultation_date as prescription_date',
 
        DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
 
        'patients.mobile as patient_phone',
 
        'patients.gender as patient_gender',
 
        'staff.name as doctor_name',
 
        'department_master.department_name as doctor_department'
 
    )
 
    ->first();
 
if(!$consultation){
    abort(404);
}
 
 
/* ---------- GET STATUS ---------- */
 
$status = DB::table('prescription_status')
            ->where('consultation_id',$id)
            ->value('status') ?? 'Pending';
 
 
/* ---------- GET MEDICINES ---------- */
 
$items = DB::table('consultation_medicines')
 
    ->join('medicines','consultation_medicines.medicine_id','=','medicines.id')
 
    ->where('consultation_medicines.consultation_id',$id)
 
    ->select(
 
        'medicines.medicine_name',
 
        'consultation_medicines.dosage',
 
        'consultation_medicines.frequency',
 
        'consultation_medicines.duration',
 
        'consultation_medicines.instructions'
 
    )
 
    ->get();
 
 
$prescription = (object)[
 
'id'=>$consultation->id,
 
'patient_name'=>$consultation->patient_name,
 
'patient_phone'=>$consultation->patient_phone,
 
'patient_gender'=>$consultation->patient_gender,
 
'doctor_name'=>$consultation->doctor_name,
 
'doctor_department'=>$consultation->doctor_department,
 
'prescription_date'=>$consultation->prescription_date,
 
'prescription_type'=>'Digital',
 
'status'=>$status,
 
'items'=>$items
 
];
 
return view('admin.pharmacy.prescriptions.show',compact('prescription'));
 
}
 
 
 
public function verify($id)
{
 
/* check if offline prescription */
$offline = OfflinePrescription::where('id',$id)->first();
 
if($offline){
 
    if($offline->status == 'Pending'){
        $offline->status = 'Verified';
        $offline->save();
    }
 
}
 
/* otherwise digital prescription */
else{
 
    DB::table('prescription_status')
        ->updateOrInsert(
 
        ['consultation_id'=>$id],
 
        [
            'id'=>Str::uuid(),
            'status'=>'Verified',
            'updated_at'=>now(),
            'created_at'=>now()
        ]
 
    );
 
}
 
return redirect()
->route('admin.prescriptions.show',$id)
->with('success','Prescription Verified Successfully');
 
}
 
 
 
 
public function createOffline()
{
 
return view('admin.pharmacy.prescriptions.create');
 
}
 
 
 
/* ================= STORE OFFLINE ================= */
 
 
public function storeOffline(Request $request)
{
 
$request->validate([
'patient_name'=>'required',
'prescription_date'=>'required'
]);
 
 
 
$count = DB::table('consultations')->count()
        + DB::table('offline_prescriptions')->count() + 1;
 
$prescription_number = 'PR-'.str_pad($count,4,'0',STR_PAD_LEFT);
 
$imagePath = null;
 
if($request->hasFile('prescription_image')){
 
$imagePath = $request->file('prescription_image')
->store('prescriptions','public');
 
}
 
 
$prescription = OfflinePrescription::create([
 
'id'=>Str::uuid(),
 
'prescription_number'=>$prescription_number,
 
'patient_name'=>$request->patient_name,
 
'patient_phone'=>$request->patient_phone,
 
'doctor_name'=>$request->doctor_name,
 
'clinic_name'=>$request->clinic_name,
 
'prescription_date'=>$request->prescription_date,
 
'uploaded_prescription'=>$imagePath,
 
'status'=>'Pending'
 
]);
 
 
foreach($request->medicine_name as $key=>$medicine){
 
OfflinePrescriptionItem::create([
 
'id'=>Str::uuid(),
 
'offline_prescription_id'=>$prescription->id,
 
'medicine_name'=>$medicine,
 
'dosage'=>$request->dosage[$key],
 
'frequency'=>$request->frequency[$key],
 
'duration'=>$request->duration[$key],
 
'instructions'=>$request->instructions[$key]
 
]);
 
}
 
 
return redirect()
->route('admin.prescriptions.index')
->with('success','Offline Prescription Saved Successfully');
 
}
 
//DISPENSE
public function dispense($id)
{
 
    /* ---------- CHECK OFFLINE PRESCRIPTION ---------- */
 
$offline = DB::table('offline_prescriptions')->where('id',$id)->first();
 
if($offline){
 
    $items = DB::table('offline_prescription_items')
        ->select(
            'medicine_name',
            'dosage',
            'frequency',
            'duration',
            'quantity'
        )
        ->where('offline_prescription_id',$id)
        ->get();
 
    foreach($items as $item){
         $frequencyParts = explode('-', $item->frequency);
$dosesPerDay = array_sum($frequencyParts);
 
$item->quantity = $dosesPerDay * ($item->duration ?? 1);
        $medicine = DB::table('medicines')
            ->where('medicine_name',$item->medicine_name)
            ->first();
 
        if($medicine){
 
            $item->medicine_id = $medicine->id;
          $batches = DB::table('medicine_batches')
        ->where('medicine_id',$item->medicine_id)
        ->where('quantity','>',0)
        ->orderBy('expiry_date','asc')
        ->get()
        ->map(function($batch){
            return (object)[
                'id'=>$batch->id,
                'batch_number'=>$batch->batch_number,
                'expiry_date'=>$batch->expiry_date,
                'quantity_available'=>$batch->quantity
            ];
        });
 
    $item->medicine = (object)[
        'name'=>$item->medicine_name,
        'batches'=>$batches
    ];
        }
    }
 
    $prescription = (object)[
 
        'id'=>$offline->id,
        'patient_id'=>null,
 
        'patient_name'=>$offline->patient_name,
 
        'doctor_name'=>$offline->doctor_name,
 
        'prescription_number'=>$offline->prescription_number,
 
        'items'=>$items
 
    ];
 
    return view('admin.pharmacy.prescriptions.dispense',compact('prescription'));
 
}
/* ---------- CHECK IPD PRESCRIPTION ---------- */

$ipd = DB::table('ipd_prescriptions')
    ->leftJoin('patients','patients.id','=','ipd_prescriptions.patient_id')
    ->leftJoin('staff','staff.id','=','ipd_prescriptions.doctor_id')
    ->where('ipd_prescriptions.id',$id)
    ->select(
        'ipd_prescriptions.id',
        'ipd_prescriptions.patient_id',
        DB::raw("CONCAT(COALESCE(patients.first_name,''),' ',COALESCE(patients.last_name,'')) as patient_name"),
        DB::raw("COALESCE(staff.name,'IPD Doctor') as doctor_name")
    )
    ->first();

if($ipd){

    $items = DB::table('ipd_prescription_items')
        ->where('prescription_id',$id)
        ->get();

    foreach($items as $item){

        // 🔥 FIX 1: SET REQUIRED QTY (default 1)
        // 🔥 CALCULATE FROM FREQUENCY

        $freqParts = explode('-', $item->frequency); // [1,1,1]

        $perDay = array_sum(array_map('intval', $freqParts)); // 3

        $days = intval($item->duration ?? 1); // 2

        $item->quantity = $perDay * $days; // 6 ✅

        // 🔥 FIX 2: MAP MEDICINE
        $medicine = DB::table('medicines')
            ->where('medicine_name',$item->medicine_name)
            ->first();

        if($medicine){

            $item->medicine_id = $medicine->id;

            $batches = DB::table('medicine_batches')
                ->where('medicine_id',$medicine->id)
                ->where('quantity','>',0)
                ->orderBy('expiry_date','asc')
                ->get();

            $item->medicine = (object)[
                'name'=>$item->medicine_name,
                'batches'=>$batches
            ];
        }
    }

    $prescription = (object)[
        'id'=>$ipd->id,
        'patient_id'=>$ipd->patient_id,
        'patient_name'=>$ipd->patient_name,   // ✅ FIXED
        'doctor_name'=>$ipd->doctor_name,     // ✅ FIXED
        'prescription_number'=>'IPD-' . substr($ipd->id,0,6), // ✅ BETTER
        'items'=>$items
    ];

    return view('admin.pharmacy.prescriptions.dispense',compact('prescription'));
}
    /* ================= GET PRESCRIPTION ================= */
 
   $prescription = DB::table('consultations')
    ->join('patients','consultations.patient_id','=','patients.id')
    ->join('staff','consultations.doctor_id','=','staff.id')
    ->where('consultations.id',$id)
    ->select(
        'consultations.id',
        'consultations.patient_id',
        DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
        'staff.name as doctor_name'
    )
    ->first();
 
if(!$prescription){
    abort(404,'Prescription not found');
}
 
    /* ===== GENERATE PRESCRIPTION NUMBER (PR-1, PR-2...) ===== */
 
    $count = DB::table('consultations')->count()
           + DB::table('offline_prescriptions')->count();
 
   $allIds = DB::table('consultations')->pluck('id')
    ->merge(DB::table('offline_prescriptions')->pluck('id'))
    ->values();

$index = $allIds->search($prescription->id);

$prescription->prescription_number = $index !== false
    ? 'PR-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)
    : '-';
 
 
    /* ================= GET MEDICINES ================= */
 
    $items = DB::table('consultation_medicines')
        ->join('medicines','consultation_medicines.medicine_id','=','medicines.id')
        ->where('consultation_medicines.consultation_id',$id)
        ->select(
            'consultation_medicines.medicine_id',
            'medicines.medicine_name as medicine_name',
            'consultation_medicines.duration as quantity'
        )
        ->get();
 
 
    foreach($items as $item){
 
        $batches = DB::table('medicine_batches')
    ->where('medicine_id',$item->medicine_id)
    ->where('quantity','>',0)
    ->orderBy('expiry_date','asc')
    ->get()
    ->map(function($batch){
        return (object)[
            'id'=>$batch->id,
            'batch_number'=>$batch->batch_number,
            'expiry_date'=>$batch->expiry_date,
            'quantity_available'=>$batch->quantity
        ];
    });
 
 $item->medicine = (object)[
        'name'=>$item->medicine_name,
        'batches'=>$batches
    ];
    }
 
 
    $prescription->items = $items;
 
    $prescription->patient = (object)[
        'name' => $prescription->patient_name
    ];
 
    $prescription->doctor = (object)[
        'name' => $prescription->doctor_name
    ];
 
 
    return view(
        'admin.pharmacy.prescriptions.dispense',
        compact('prescription')
    );
}
 
 
 
public function storeDispense(Request $request, $id)
{
    // 🔍 CHECK IF IPD
    $ipd = DB::table('ipd_prescriptions')->where('id',$id)->first();

    // ============================
    // 🔥 IPD FLOW (NO SALES BILL)
    // ============================
    if($ipd){

        foreach ($request->medicine_id as $key => $medicine){

            if(!$medicine) continue;

            $batch_id = $request->batch_id[$key];
            $qty = $request->dispense_qty[$key];

            DB::table('pharmacy_ipd_dispense')->insert([
                'id' => Str::uuid(),
                'prescription_id' => $id,
                'patient_id' => $ipd->patient_id,
                'medicine_id' => $medicine,
                'medicine_name' => $request->medicine_name[$key] ?? '',
                'quantity' => $request->required_qty[$key] ?? 0,
                'dispensed_quantity' => $qty,
                'batch_id' => $batch_id,
                'dispensed_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // ✅ STOCK UPDATE
            DB::table('medicine_batches')
                ->where('id',$batch_id)
                ->decrement('quantity',$qty);
        }

        // ✅ UPDATE IPD STATUS
         DB::table('ipd_prescriptions')
        ->where('id', $id)
        ->update([
            'status' => 'Dispensed',
            'updated_at' => now()
        ]);

        return redirect()->route('admin.prescriptions.index')
            ->with('success','IPD Medicines Dispensed Successfully');
    }

    // ============================
    // 🔥 NORMAL FLOW (OPD/OFFLINE)
    // ============================

    $bill_id = Str::uuid();

    // GET PATIENT NAME
    $patientName = null;

    if ($request->patient_id) {
        $patient = \App\Models\Patient::find($request->patient_id);
        $patientName = $patient->name ?? null;
    } else {
        $offline = \App\Models\OfflinePrescription::where('id', $id)->first();
        $patientName = $offline->patient_name ?? null;
    }

    // GENERATE PRESCRIPTION NUMBER
    $prescriptionNumber = 'PR-' . str_pad(
        DB::table('sales_bills')->count() + 1,
        4,
        '0',
        STR_PAD_LEFT
    );

    // CREATE BILL
    DB::table('sales_bills')->insert([
        'bill_id' => $bill_id,
        'bill_number' => 'BILL'.time(),
        'patient_id' => $request->patient_id ?? null,
        'patient_name' => $patientName,
        'prescription_id' => $id,
        'prescription_number' => $prescriptionNumber,
        'total_amount' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // SAVE ITEMS
    if($request->has('medicine_id')){

        foreach($request->medicine_id as $key => $medicine){

            if(!$medicine) continue;

            $batch_id = $request->batch_id[$key];
            $qty = $request->dispense_qty[$key];

            SalesBillItem::create([
                'sales_bill_id' => $bill_id,
                'medicine_id' => $medicine,
                'batch_id' => $batch_id,
                'quantity' => $qty,
                'unit_price' => 10,
                'total_price' => $qty * 10
            ]);

            DB::table('medicine_batches')
                ->where('id',$batch_id)
                ->decrement('quantity',$qty);
        }

        // CALCULATE TOTAL
        $total = DB::table('sales_bill_items')
            ->where('sales_bill_id', $bill_id)
            ->sum('total_price');

        DB::table('sales_bills')
            ->where('bill_id', $bill_id)
            ->update([
                'total_amount' => $total,
                'balance_amount' => $total
            ]);
    }

    // UPDATE STATUS
    DB::table('prescription_status')
        ->updateOrInsert(
            ['consultation_id' => $id],
            [
                'id' => Str::uuid(),
                'status' => 'Dispensed',
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

    $offline = OfflinePrescription::where('id',$id)->first();
    if($offline){
        $offline->status = 'Dispensed';
        $offline->save();
    }

    return redirect()->route('admin.prescriptions.bill',$bill_id);
}
/* ================= SHOW BILL ================= */
 
public function showBill($id)
{
 
    /* GET BILL */
    $bill = DB::table('sales_bills')
        ->where('bill_id',$id)
        ->first();
 
 
    /* GET PATIENT DETAILS */
 
    $patient = null;

if(!empty($bill->patient_id)){

    $patient = DB::table('patients')
        ->where('id',$bill->patient_id)
        ->select(
            DB::raw("CONCAT(first_name,' ',last_name) as patient_name"),
            'mobile as phone'
        )
        ->first();

}else if(!empty($bill->prescription_id)){

    $patient = DB::table('offline_prescriptions')
        ->where('id',$bill->prescription_id)
        ->select(
            'patient_name',
            'patient_phone as phone'
        )
        ->first();
}

$bill->patient = $patient;
 
 
    /* PRESCRIPTION NUMBER */
 
    /* PRESCRIPTION NUMBER */

$bill->prescription_number = $bill->prescription_id 
    ? 'PR-' . substr($bill->prescription_id, 0, 6) 
    : '-';
 
 
    /* BILL ITEMS */
 
    $items = DB::table('sales_bill_items')
        ->join('medicines','sales_bill_items.medicine_id','=','medicines.id')
        ->where('sales_bill_items.sales_bill_id',$id)
        ->select(
            'medicines.medicine_name',
            'sales_bill_items.quantity',
            'sales_bill_items.unit_price'
        )
        ->get();
 
    $bill->items = $items;
 
 
    return view('admin.pharmacy.prescriptions.bill',compact('bill'));
 
}
public function reject($id)
{
 
$offline = OfflinePrescription::where('id',$id)->first();
 
if($offline){
 
    $offline->status = 'Rejected';
    $offline->save();
 
}else{
 
    DB::table('prescription_status')
    ->updateOrInsert(
        ['consultation_id'=>$id],
        [
            'id'=>Str::uuid(),
            'status'=>'Rejected',
            'updated_at'=>now(),
            'created_at'=>now()
        ]
    );
 
}
 
return redirect()
->route('admin.prescriptions.show',$id)
->with('success','Prescription Rejected Successfully');
 
}
 //API ENDPOINT TO GET PRESCRIPTION DETAILS
 
public function apiIndex()
{
 
$digital = DB::table('consultations')
->join('patients','patients.id','=','consultations.patient_id')
->join('staff','staff.id','=','consultations.doctor_id')
->leftJoin('prescription_status','consultations.id','=','prescription_status.consultation_id')
->select(
 
'consultations.id',
 
DB::raw("CONCAT('PR-',LPAD(consultations.id,4,'0')) as prescription_number"),
 
DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
 
'staff.name as doctor_name',
 
'consultations.consultation_date as prescription_date',
 
DB::raw("'Digital' as prescription_type"),
 
DB::raw("COALESCE(prescription_status.status,'Pending') as status")
 
)
->get();
 
$ipd = DB::table('ipd_prescriptions')
    ->join('patients','patients.id','=','ipd_prescriptions.patient_id')
    ->join('staff','staff.id','=','ipd_prescriptions.doctor_id')
    ->select(
        'ipd_prescriptions.id',
        DB::raw("'IPD-' as prescription_number"),
        DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
        'staff.name as doctor_name',
        'ipd_prescriptions.prescription_date',
        DB::raw("'IPD' as prescription_type"),
        DB::raw("'Pending' as status")
    )
    ->get();

$prescriptions = $digital->merge($offline)->merge($ipd)->values();
 
$offline = DB::table('offline_prescriptions')
->select(
 
'id',
'prescription_number',
'patient_name',
'doctor_name',
'prescription_date',
 
DB::raw("'Offline' as prescription_type"),
 
'status'
 
)->get();
 
 
$prescriptions = $digital->merge($offline)
->sortByDesc('prescription_date')
->values();
 
 
return response()->json([
'success'=>true,
'data'=>$prescriptions
]);
 
}
public function apiShow($id)
{

    /* ---------- CHECK OFFLINE PRESCRIPTION ---------- */

    $offline = DB::table('offline_prescriptions')->where('id', $id)->first();

    if ($offline) {

        $items = DB::table('offline_prescription_items')
            ->where('offline_prescription_id', $id)
            ->select(
                'medicine_name',
                'dosage',
                'frequency',
                'duration'
            )
            ->get();

        return response()->json([
            'success' => true,
            'prescription' => [
                'id' => $offline->id,
                'prescription_number' => 'OFF-' . str_pad($offline->id, 4, '0', STR_PAD_LEFT),
                'patient_name' => $offline->patient_name,
                'mobile' => $offline->patient_phone,
                'doctor_name' => $offline->doctor_name,
                'prescription_date' => $offline->prescription_date,
                'prescription_type' => 'Offline',
                'status' => $offline->status,
            ],
            'medicines' => $items
        ]);
    }


    /* ---------- DIGITAL PRESCRIPTION ---------- */

    $prescription = DB::table('consultations')
        ->join('patients', 'consultations.patient_id', '=', 'patients.id')
        ->join('staff', 'consultations.doctor_id', '=', 'staff.id')
        ->where('consultations.id', $id)
        ->select(
            'consultations.id',
            DB::raw("CONCAT('PR-',LPAD(consultations.id,4,'0')) as prescription_number"),
            DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
            'patients.mobile',
            'staff.name as doctor_name',
            'consultations.consultation_date as prescription_date'
        )
        ->first();

    if (!$prescription) {
        return response()->json([
            'success' => false,
            'message' => 'Prescription not found'
        ], 404);
    }

    $items = DB::table('consultation_medicines')
        ->join('medicines', 'consultation_medicines.medicine_id', '=', 'medicines.id')
        ->where('consultation_medicines.consultation_id', $id)
        ->select(
            'medicines.medicine_name',
            'consultation_medicines.dosage',
            'consultation_medicines.frequency',
            'consultation_medicines.duration'
        )
        ->get();

    return response()->json([
        'success' => true,
        'prescription' => [
            'id' => $prescription->id,
            'prescription_number' => $prescription->prescription_number,
            'patient_name' => $prescription->patient_name,
            'mobile' => $prescription->mobile,
            'doctor_name' => $prescription->doctor_name,
            'prescription_date' => $prescription->prescription_date,
            'prescription_type' => 'Digital',
            'status' => 'Pending'
        ],
        'medicines' => $items
    ]);
}
public function apiDispense(Request $request,$id)
{
    $bill_id = Str::uuid();

    // Patient name
    if($request->patient_id){
        $patient = DB::table('patients')->where('id',$request->patient_id)->first();
        $patientName = $patient->name ?? null;
    } else {
        $offline = DB::table('offline_prescriptions')->where('id',$id)->first();
        $patientName = $offline->patient_name ?? null;
    }

    DB::table('sales_bills')->insert([
        'bill_id'=>$bill_id,
        'bill_number'=>'BILL'.time(),
        'patient_id'=>$request->patient_id,
        'patient_name'=>$patientName,
        'prescription_id'=>$id,
        'total_amount'=>0,
        'created_at'=>now(),
        'updated_at'=>now()
    ]);

    foreach($request->items as $item){

        DB::table('sales_bill_items')->insert([
            'id' => Str::uuid(), // ✅ ADD THIS
            'sales_bill_id'=>$bill_id,
            'medicine_id'=>$item['medicine_id'],
            'batch_id'=>$item['batch_id'],
            'quantity'=>$item['qty'],
            'unit_price'=>10,
            'total_price'=>$item['qty'] * 10
        ]);

        DB::table('medicine_batches')
            ->where('id',$item['batch_id'])
            ->decrement('quantity',$item['qty']);
    }

    $total = DB::table('sales_bill_items')
        ->where('sales_bill_id',$bill_id)
        ->sum('total_price');

    DB::table('sales_bills')
        ->where('bill_id',$bill_id)
        ->update([
            'total_amount'=>$total
        ]);

    return response()->json([
        'success'=>true,
        'message'=>'Medicines dispensed successfully'
    ]);
}
public function apiReject($id)
{
    $prescription = Prescription::find($id);

    if (!$prescription) {
        return response()->json([
            'success' => false,
            'message' => 'Prescription not found'
        ], 404);
    }

    // ✅ UPDATE STATUS
    $prescription->status = 'rejected';
    $prescription->save();

    return response()->json([
        'success' => true,
        'message' => 'Prescription rejected successfully',
        'data' => $prescription   // return updated data
    ]);
}
public function apiBill($id)
{
    // ✅ Get bill using prescription_id
    $bill = DB::table('sales_bills')
        ->where('prescription_id', $id)
        ->first();

    if (!$bill) {
        return response()->json([
            'success' => false,
            'message' => 'Bill not found'
        ]);
    }

    // ✅ Use bill_id (NOT id)
    $items = DB::table('sales_bill_items')
        ->join('medicines', 'sales_bill_items.medicine_id', '=', 'medicines.id')
        ->where('sales_bill_items.sales_bill_id', $bill->bill_id) // ✅ FIXED
        ->select(
            'medicines.medicine_name',
            'sales_bill_items.quantity',
            'sales_bill_items.unit_price as price',
            DB::raw('sales_bill_items.quantity * sales_bill_items.unit_price as total')
        )
        ->get();

    return response()->json([
        'success' => true,
        'data' => [
            'patient_name' => $bill->patient_name,
            'bill_number' => $bill->bill_number,
            'date' => $bill->created_at,
            'items' => $items,
            'grand_total' => $bill->total_amount
        ]
    ]);
}
public function print($id)
{
    /* GET BILL */
    $bill = DB::table('sales_bills')
    ->where('prescription_id', $id)
    ->first();

    if(!$bill){
        abort(404,'Bill not found');
    }

    /* GET PATIENT DETAILS */
    $patient = null;

    if(!empty($bill->patient_id)){

        $patient = DB::table('patients')
            ->where('id',$bill->patient_id)
            ->select(
                DB::raw("CONCAT(first_name,' ',last_name) as patient_name"),
                'mobile as phone'
            )
            ->first();

    }else if(!empty($bill->prescription_id)){

        $patient = DB::table('offline_prescriptions')
            ->where('id',$bill->prescription_id)
            ->select(
                'patient_name',
                'patient_phone as phone'
            )
            ->first();
    }

    $bill->patient = $patient;

    /* ✅ PRESCRIPTION NUMBER (FIXED VARIABLE) */
   /* PRESCRIPTION NUMBER (SAFE VERSION) */

/* PRESCRIPTION NUMBER (SIMPLE & WORKING) */
$bill->prescription_number = $bill->prescription_number ?? '-';
    /* BILL ITEMS */
    $items = DB::table('sales_bill_items')
        ->join('medicines','sales_bill_items.medicine_id','=','medicines.id')
        ->where('sales_bill_items.sales_bill_id',$bill->bill_id)
        ->select(
            'medicines.medicine_name',
            'sales_bill_items.quantity',
            'sales_bill_items.unit_price'
        )
        ->get();

    $bill->items = $items;

    return view('admin.pharmacy.prescriptions.bill',compact('bill'));
}

//added
public function apiStoreOffline(Request $request)
{
    $request->validate([
        'patient_name' => 'required',
        'prescription_date' => 'required'
    ]);

    $count = DB::table('consultations')->count()
        + DB::table('offline_prescriptions')->count() + 1;

    $prescription_number = 'PR-' . str_pad($count, 4, '0', STR_PAD_LEFT);

    $imagePath = null;

    if ($request->hasFile('prescription_image')) {
        $imagePath = $request->file('prescription_image')
            ->store('prescriptions', 'public');
    }

    $prescription = OfflinePrescription::create([
        'id' => Str::uuid(),
        'prescription_number' => $prescription_number,
        'patient_name' => $request->patient_name,
        'patient_phone' => $request->patient_phone,
        'doctor_name' => $request->doctor_name,
        'clinic_name' => $request->clinic_name,
        'prescription_date' => $request->prescription_date,
        'uploaded_prescription' => $imagePath,
        'status' => 'Pending'
    ]);

    foreach ($request->medicine_name as $key => $medicine) {
        OfflinePrescriptionItem::create([
            'id' => Str::uuid(),
            'offline_prescription_id' => $prescription->id,
            'medicine_name' => $medicine,
            'dosage' => $request->dosage[$key],
            'frequency' => $request->frequency[$key],
            'duration' => $request->duration[$key],
            'instructions' => $request->instructions[$key]
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Offline Prescription Created',
        'data' => $prescription
    ]);
}

public function apiDispenseData($id)
{
    /* ---------- CHECK OFFLINE ---------- */
    $offline = DB::table('offline_prescriptions')->where('id',$id)->first();

    if($offline){

        $items = DB::table('offline_prescription_items')
            ->where('offline_prescription_id',$id)
            ->get();

        foreach($items as $item){

            /* ✅ CALCULATE REQUIRED QTY (same as web) */
            $frequencyParts = explode('-', $item->frequency);
            $dosesPerDay = array_sum($frequencyParts);
            $requiredQty = $dosesPerDay * ($item->duration ?? 1);

            /* ✅ FIND MEDICINE ID FROM NAME */
            $medicine = DB::table('medicines')
                ->where('medicine_name',$item->medicine_name)
                ->first();

            $batches = [];

            if($medicine){

                $item->medicine_id = $medicine->id;

                /* ✅ FETCH BATCHES (IMPORTANT) */
                $batches = DB::table('medicine_batches')
                    ->where('medicine_id',$medicine->id)
                    ->where('quantity','>',0)
                    ->orderBy('expiry_date','asc')
                    ->get()
                    ->map(function($batch){
                        return [
                            'id' => $batch->id,
                            'batch_number' => $batch->batch_number,
                            'expiry_date' => $batch->expiry_date,
                            'quantity_available' => $batch->quantity
                        ];
                    });
            }

            $item->required_qty = $requiredQty;
            $item->batches = $batches;
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $offline->id,
                'patient_name' => $offline->patient_name,
                'doctor_name' => $offline->doctor_name,
                'items' => $items
            ]
        ]);
    }

    /* ---------- DIGITAL ---------- */

    $prescription = DB::table('consultations')
        ->join('patients','consultations.patient_id','=','patients.id')
        ->join('staff','consultations.doctor_id','=','staff.id')
        ->where('consultations.id',$id)
        ->select(
            'consultations.id',
            DB::raw("CONCAT(patients.first_name,' ',patients.last_name) as patient_name"),
            'staff.name as doctor_name'
        )
        ->first();

    if(!$prescription){
        return response()->json([
            'status'=>false,
            'message'=>'Prescription not found'
        ]);
    }

    $items = DB::table('consultation_medicines')
        ->join('medicines','consultation_medicines.medicine_id','=','medicines.id')
        ->where('consultation_medicines.consultation_id',$id)
        ->select(
            'consultation_medicines.medicine_id',
            'medicines.medicine_name',
            'consultation_medicines.duration as required_qty'
        )
        ->get();

    foreach($items as $item){

        $batches = DB::table('medicine_batches')
            ->where('medicine_id',$item->medicine_id)
            ->where('quantity','>',0)
            ->orderBy('expiry_date','asc')
            ->get()
            ->map(function($batch){
                return [
                    'id'=>$batch->id,
                    'batch_number'=>$batch->batch_number,
                    'expiry_date'=>$batch->expiry_date,
                    'quantity_available'=>$batch->quantity
                ];
            });

        $item->batches = $batches;
    }

    return response()->json([
        'status'=>true,
        'data'=>[
            'id'=>$prescription->id,
            'patient_name'=>$prescription->patient_name,
            'doctor_name'=>$prescription->doctor_name,
            'items'=>$items
        ]
    ]);
}
 
}
 