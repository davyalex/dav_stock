<?php

namespace App\Http\Controllers\backend\basic_site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use RealRashid\SweetAlert\Facades\Alert;

class TemoignageController extends Controller
{
    //
    public function index()
    {

        $data_temoignage = Temoignage::orderBy('created_at', 'DESC')->get();

        return view('backend.pages.temoignage.index', compact('data_temoignage'));
    }


    public function store(Request $request)
    {
        //request validation .......

        $data_temoignage = Temoignage::firstOrCreate([
            'name' => $request['name'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);


        if (request()->hasFile('image')) {
            $data_temoignage->addMediaFromRequest('image')->toMediaCollection('temoignageImage');
        }


        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_temoignage = tap(Temoignage::find($id))->update([

            'name' => $request['name'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);


        if (request()->hasFile('image')) {
            $data_temoignage->clearMediaCollection('temoignageImage');
            $data_temoignage->addMediaFromRequest('image')->toMediaCollection('temoignageImage');
        }



        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        Temoignage::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
