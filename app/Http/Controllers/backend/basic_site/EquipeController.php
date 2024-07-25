<?php

namespace App\Http\Controllers\backend\basic_site;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class EquipeController extends Controller
{
    //

    public function index()
    {

        $data_equipe = Equipe::with('media')->get();
        $data_equipe->sortBy('name');

        return view('backend.pages.equipe.index', compact('data_equipe'));
    }


    public function store(Request $request)
    {
        //request validation .......

        $data_equipe = Equipe::firstOrCreate([
            'name' => $request['name'],
            'job' => $request['job'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_equipe->addMediaFromRequest('image')->toMediaCollection('equipeImage');
        }


        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_equipe = tap(Equipe::find($id))->update([
            'name' => $request['name'],
            'job' => $request['job'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_equipe->clearMediaCollection('equipeImage');
            $data_equipe->addMediaFromRequest('image')->toMediaCollection('equipeImage');
        }

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        Equipe::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
