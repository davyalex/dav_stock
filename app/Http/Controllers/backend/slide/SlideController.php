<?php

namespace App\Http\Controllers\backend\slide;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class SlideController extends Controller
{
    //

    public function index()
    {
        try {

            $data_slide = Slide::with('media')->get();

            return view('backend.pages.slide.index', compact('data_slide'));
        } catch (\Throwable $e) {
            Alert::error('Error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        //request validation .......

        $data_Slide = Slide::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'btn_name' => $request['btn_name'],
            'btn_url' => $request['btn_url'],
            'btn_color' => $request['btn_color'],
            'type' => $request['type'],
            'btn_status' => $request['btn_status'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_Slide->addMediaFromRequest('image')->toMediaCollection($request['type']);
        }


        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_Slide = tap(Slide::find($id))->update([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'btn_name' => $request['btn_name'],
            'btn_url' => $request['btn_url'],
            'btn_color' => $request['btn_color'],
            'type' => $request['type'],
            'btn_status' => $request['btn_status'],
            'status' => $request['status'],
        ]);

        if (request()->hasFile('image')) {
            $data_Slide->clearMediaCollection($request['type']);
            $data_Slide->addMediaFromRequest('image')->toMediaCollection($request['type']);
        }

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        Slide::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
