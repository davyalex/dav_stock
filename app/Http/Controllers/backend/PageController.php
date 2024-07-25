<?php

namespace App\Http\Controllers\backend;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PageController extends Controller
{
    //

    public function index()
    {
        $data_page = Page::get();
        $data_page = $data_page->SortBy('name');

        return view('backend.pages.page.index', compact('data_page'));
    }


    public function create()
    {
        return view('backend.pages.page.create');
    }


    public function store(Request $request)
    {
        //request validation .....'name'
        // dd($request->all());
        $data_page = Page::create([
            'name' => $request['name'],
            'status' => $request['status'],
            'content' => $request['content'],
        ]);

        Alert::Success('Opération', 'SuccessMessage');
        return back();
    }


    public function edit($id)
    {
        $data_page = Page::find($id);

        return view('backend.pages.page.edit', compact('data_page'));
    }



    public function update(Request $request, $id)
    {

        //request validation ......

        $data_page = Page::find($id)->update([
            'name' => $request['name'],
            'status' => $request['status'],
            'content' => $request['content'],
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        Page::find($id)->delete();
        return response()->json([
            'status'=>200,
        ]);
       
    }
}
