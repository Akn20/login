<?php

namespace App\Http\Controllers\Admin\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{

/*
|--------------------------------------------------------------------------
| 1. Prescription List
|--------------------------------------------------------------------------
*/

public function index()
{

$prescriptions = [

(object)[
'id'=>1,
'prescription_number'=>'RX1001',
'patient'=>(object)['name'=>'Ramesh Kumar'],
'doctor'=>(object)['name'=>'Dr Sharma'],
'prescription_date'=>'2026-03-09',
'prescription_type'=>'Digital',
'status'=>'Pending'
],

(object)[
'id'=>2,
'prescription_number'=>'RX1002',
'patient'=>(object)['name'=>'Suresh'],
'doctor'=>(object)['name'=>'Dr Mehta'],
'prescription_date'=>'2026-03-09',
'prescription_type'=>'Offline',
'status'=>'Verified'
]

];

return view(
'admin.pharmacy.prescriptions.index',
compact('prescriptions')
);

}



/*
|--------------------------------------------------------------------------
| 2. Prescription Details
|--------------------------------------------------------------------------
*/

public function show($id)
{

$prescription = (object)[

'id'=>1,
'prescription_number'=>'RX1001',
'prescription_date'=>'2026-03-09',
'prescription_type'=>'Digital',
'status'=>'Pending',   // ADD THIS LINE

'patient'=>(object)[
'name'=>'Ramesh Kumar',
'phone'=>'9876543210',
'age'=>35,
'gender'=>'Male'
],

'doctor'=>(object)[
'name'=>'Dr Sharma',
'department'=>'General Medicine'
],

'items'=>[

(object)[
'medicine'=>(object)['name'=>'Paracetamol'],
'dosage'=>'500mg',
'frequency'=>'3/day',
'duration'=>'5 days',
'quantity'=>15,
'instructions'=>'After food'
],

(object)[
'medicine'=>(object)['name'=>'Vitamin C'],
'dosage'=>'1 tablet',
'frequency'=>'1/day',
'duration'=>'10 days',
'quantity'=>10,
'instructions'=>'Morning'
]

]

];

return view(
'admin.pharmacy.prescriptions.show',
compact('prescription')
);

}



/*
|--------------------------------------------------------------------------
| 3. Verify Prescription
|--------------------------------------------------------------------------
*/

public function verify($id)
{

return redirect()
->back()
->with('success','Prescription Verified');

}



/*
|--------------------------------------------------------------------------
| 4. Offline Prescription Form
|--------------------------------------------------------------------------
*/

public function createOffline()
{

return view('admin.pharmacy.prescriptions.create');

}



/*
|--------------------------------------------------------------------------
| 5. Save Offline Prescription
|--------------------------------------------------------------------------
*/

public function storeOffline(Request $request)
{

return redirect()
->route('pharmacy.prescriptions.index')
->with('success','Offline Prescription Saved');

}



/*
|--------------------------------------------------------------------------
| 6. Dispense Page
|--------------------------------------------------------------------------
*/

public function dispense($id)
{

$prescription = (object)[

'id'=>1,
'prescription_number'=>'RX1001',

'patient'=>(object)[
'name'=>'Ramesh Kumar'
],

'doctor'=>(object)[
'name'=>'Dr Sharma'
],

'items'=>[

(object)[
'medicine'=>(object)[
'name'=>'Paracetamol',
'batches'=>[
(object)[
'id'=>1,
'batch_number'=>'B001',
'expiry_date'=>'2027-05',
'quantity_available'=>200
],
(object)[
'id'=>2,
'batch_number'=>'B002',
'expiry_date'=>'2026-10',
'quantity_available'=>100
]
]
],
'quantity'=>15
],

(object)[
'medicine'=>(object)[
'name'=>'Vitamin C',
'batches'=>[
(object)[
'id'=>3,
'batch_number'=>'B003',
'expiry_date'=>'2027-03',
'quantity_available'=>50
]
]
],
'quantity'=>10
]

]

];

return view(
'admin.pharmacy.prescriptions.dispense',
compact('prescription')
);

}



/*
|--------------------------------------------------------------------------
| 7. Save Dispense
|--------------------------------------------------------------------------
*/

public function storeDispense(Request $request,$id)
{

return redirect()
->route('admin.prescriptions.bill',1);

}



/*
|--------------------------------------------------------------------------
| 8. Show Bill
|--------------------------------------------------------------------------
*/

public function showBill($id)
{

$bill = (object)[

'bill_number'=>'BILL1001',

'created_at'=>'2026-03-09',

'patient'=>(object)[
'name'=>'Ramesh Kumar',
'phone'=>'9876543210'
],

'prescription'=>(object)[
'prescription_number'=>'RX1001'
],

'items'=>[

(object)[
'medicine'=>(object)['name'=>'Paracetamol'],
'quantity'=>15,
'price'=>5
],

(object)[
'medicine'=>(object)['name'=>'Vitamin C'],
'quantity'=>10,
'price'=>8
]

]

];

return view('admin.pharmacy.prescriptions.bill', compact('bill'));
}

}