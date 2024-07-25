<?php

namespace App\Http\Controllers\backend\basic_site;

use App\Models\Reference;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReferenceSite;
use League\CommonMark\Reference\Reference as ReferenceReference;
use RealRashid\SweetAlert\Facades\Alert;

class ReferenceController extends Controller
{
    //
    public function index()
    {

        $data_reference = ReferenceSite::with('media')->get();
        $data_reference->sortBy('name');

        return view('backend.pages.reference.index', compact('data_reference'));
    }


    public function store(Request $request)
    {
        //request validation .......

        $data_reference = ReferenceSite::firstOrCreate([
            'name' => $request['name'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_reference->addMediaFromRequest('image')->toMediaCollection('referenceImage');
        }


        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_reference = tap(ReferenceSite::find($id))->update([
            'name' => $request['name'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_reference->clearMediaCollection('referenceImage');
            $data_reference->addMediaFromRequest('image')->toMediaCollection('referenceImage');
        }

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        ReferenceSite::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    
}
