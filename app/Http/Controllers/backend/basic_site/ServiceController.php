<?php

namespace App\Http\Controllers\backend\basic_site;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $data_service = Service::get();
        $data_service = $data_service->SortBy('name');

        return view('backend.pages.service.index', compact('data_service'));
    }


    public function create(Request $request)
    {
        return view('backend.pages.service.create');
    }


    public function store(Request $request)
    {
        //request validation .....
        // dd($request->all());
        $data_service = Service::create([
            'title' => $request['title'],
            'status' => $request['status'],
            'resume' => $request['resume'],
            'description' => $request['description'],
        ]);

        if (request()->hasFile('image')) {
            // $data_service->clearMediaCollection('serviceImage');
            $data_service->addMediaFromRequest('image')->toMediaCollection('serviceImage');
        }

        Alert::Success('Opération', 'SuccessMessage');
        return back();
    }


    public function edit($id)
    {
        $data_service = Service::find($id);

        return view('backend.pages.service.edit', compact('data_service'));
    }



    public function update(Request $request, $id)
    {

        //request validation ......

        $data_service = tap(Service::find($id))->update([
            'title' => $request['title'],
            'status' => $request['status'],
            'resume' => $request['resume'],
            'description' => $request['description'],
        ]);

        if (request()->hasFile('image')) {
            $data_service->clearMediaCollection('serviceImage');
            $data_service->addMediaFromRequest('image')->toMediaCollection('serviceImage');
        }

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        service::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
