<?php

namespace App\Http\Controllers\backend\configuration;

use App\Models\Format;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class FormatController extends Controller
{
    //
    public function index()
    {

        $data_format = Format::get();
        $data_format->sortBy('libelle');

        return view('backend.pages.configuration.format.index', compact('data_format'));
    }


    public function store(Request $request)
    {


        try {
            $data =  $request->validate([
                'libelle' => 'required',
                'abreviation' => 'required',
            ]);
            $data_format = Format::firstOrCreate($data);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data_format = tap(Format::find($id))->update([
                'libelle' => $request['libelle'],
                'abreviation' => $request['abreviation'],

            ]);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }


    public function delete($id)
    {
        try {
            Format::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
