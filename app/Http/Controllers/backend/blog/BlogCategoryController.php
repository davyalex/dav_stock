<?php

namespace App\Http\Controllers\backend\blog;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogContent;
use RealRashid\SweetAlert\Facades\Alert;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data_blog_category = BlogCategory::OrderBy('position', 'ASC')->get();


        return view('backend.pages.blog.category.index', compact('data_blog_category'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //request validation .......


        $data_count = BlogCategory::count();

        $data_blog_category = BlogCategory::firstOrCreate([
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


        BlogCategory::find($id)->update([
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

        $data_page = BlogCategory::find($id)->update([
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
        //delete content of category
        BlogContent::where('blog_categories_id', $id)->delete();
        BlogCategory::find($id)->delete();

        //
        $data_blog_category = BlogCategory::OrderBy('position', 'ASC')->get();

        foreach ($data_blog_category as $key => $value) {
            BlogCategory::whereId($value['id'])->update([
                'position' => $key + 1
            ]);
        }
        //
        return response()->json([
            'status' => 200,
        ]);
    }
}
