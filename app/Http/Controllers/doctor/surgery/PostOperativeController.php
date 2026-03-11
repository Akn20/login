<?php

namespace App\Http\Controllers\doctor\surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use App\Models\PostOperative;

class PostOperativeController extends Controller
{

    public function index()
    {
        $posts = PostOperative::with('surgery.patient')->latest()->get();

        return view('doctor.surgery.postoperative.index', compact('posts'));
    }

    public function create($surgery_id)
    {

        $surgery = Surgery::findOrFail($surgery_id);

        $post = PostOperative::where('surgery_id',$surgery_id)->first();

        return view('doctor.surgery.postoperative.create',compact('surgery','post'));

    }

    public function edit($id)
    {
        $post = PostOperative::with('surgery.patient')->findOrFail($id);

        return view('doctor.surgery.postoperative.edit', compact('post'));
    }

    public function store(Request $request)
    {

        PostOperative::updateOrCreate(

            ['surgery_id'=>$request->surgery_id],

            [

                'procedure_performed'=>$request->procedure_performed,
                'duration'=>$request->duration,
                'blood_loss'=>$request->blood_loss,
                'patient_condition'=>$request->patient_condition,
                'recovery_instructions'=>$request->recovery_instructions,
                'complication_type'=>$request->complication_type,
                'complication_description'=>$request->complication_description

            ]

        );

        return redirect()->route('surgery.index')
        ->with('success','Post Operative Details Saved');

    }

    public function update(Request $request, $id)
    {
        $post = PostOperative::findOrFail($id);

        $post->update([

            'procedure_performed'=>$request->procedure_performed,
            'duration'=>$request->duration,
            'blood_loss'=>$request->blood_loss,
            'patient_condition'=>$request->patient_condition,
            'recovery_instructions'=>$request->recovery_instructions,
            'complication_type'=>$request->complication_type,
            'complication_description'=>$request->complication_description

        ]);

        return redirect()->route('post.index')
        ->with('success','Post Operative Details Updated');

    }

    public function destroy($id)
    {
        $post = PostOperative::findOrFail($id);
        $post->delete();

        return redirect()->route('post.index')
        ->with('success','Postoperative record deleted');
    }

}