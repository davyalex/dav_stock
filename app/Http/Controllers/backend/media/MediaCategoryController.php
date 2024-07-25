<?php

namespace App\Http\Controllers\backend\media;

use App\Models\MediaContent;
use Illuminate\Http\Request;
use App\Models\MediaCategory;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class MediaCategoryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data_media_category = MediaCategory::OrderBy('position', 'ASC')->get();
        return view('backend.pages.media.category.index', compact('data_media_category'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //request validation .......

        $data_count = MediaCategory::count();


        $data_media_category = MediaCategory::firstOrCreate([
            'name' => $request['name'],
            'status' => $request['status'],
            'position' => $data_count + 1,

        ]);

        Alert::success('Operation réussi', 'Success Message');

        return back();
    }

    public function position(Request $request, $id)
    {

        $position = $request['position'];


        MediaCategory::find($id)->update([
            'position' => $position,
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //request validation ......

        $data_media_category = MediaCategory::find($id)->update([
            'name' => $request['name'],
            'status' => $request['status'],
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {

        MediaContent::where('media_categories_id', $id)->delete();
        MediaCategory::find($id)->delete();

        //
        //
        $data_media_category = MediaCategory::OrderBy('position', 'ASC')->get();

        foreach ($data_media_category as $key => $value) {
            MediaCategory::whereId($value['id'])->update([
                'position' => $key + 1
            ]);
        }
        //
        //

        return response()->json([
            'status' => 200,
        ]);
    }
}
