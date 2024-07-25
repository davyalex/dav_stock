<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    //
    // public function index()
    // {
    //     return view('backend.pages.menu.create');
    // }

    public function create()
    {


        //create menu principal
        $data_menu = Menu::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();

        // dd($data_menu->toArray());
        return view('backend.pages.menu.create', compact('data_menu'));
    }



    public function store(Request $request)
    {

        //request validation ......


        $data_count = Menu::where('parent_id', null)->count();
        // dd($data_count);

        $data_menu = Menu::firstOrCreate([
            'name' => $request['name'],
            'status' => $request['status'],
            'url' => $request['url'],
            'position' => $data_count + 1,
        ]);

        Alert::success('Operation réussi', 'Success Message');

        return back();
    }

    /**page view for add item */
    public function addMenuItem(Request $request, $id)
    {
        //List menu
        $data_menu = Menu::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();

        $data_menu_parent = Menu::find($id);


        return view('backend.pages.menu.menu-item',  compact('data_menu', 'data_menu_parent'));
    }


    public function addMenuItemStore(Request $request)
    {
        //request validation ......

        // $data_menu_count = Menu::max('position');

        // $position =  $data_menu_count + 1;

        $menu_parent = Menu::whereName($request['menu_parent'])->first();

        //function for add position
        $data_count = Menu::where('parent_id', $menu_parent['id'])->count();

        $data_menu = Menu::firstOrCreate([
            'parent_id' => $menu_parent['id'],
            'name' => $request['name'],
            'status' => $request['status'],
            'url' => $request['url'],
            'position' => $data_count + 1,
        ]);

        Alert::success('Operation réussi', 'Success Message');

        return redirect()->route('menu.create');
    }


    public function edit(Request $request, $id)
    {
        //List menu
        $data_menu = Menu::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();


        $data_menu_edit = Menu::find($id);

        $data_count = Menu::where('parent_id', $data_menu_edit['parent_id'])->count();
        // dd($data_count);

        return view('backend.pages.menu.menu-edit',  compact('data_menu', 'data_menu_edit', 'data_count'));
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_menu = Menu::find($id)->update([
            'name' => $request['name'],
            'status' => $request['status'],
            'url' => $request['url'],
            'position' => $request['position'],
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return redirect()->route('menu.create');
    }


    public function delete($id)
    {
        //
        $data_menu_edit = Menu::find($id);
        $data_menu = Menu::where('parent_id', $data_menu_edit['parent_id'])->get();
        foreach ($data_menu as $key => $value) {
            Menu::whereId($value['id'])->update([
                'position' => $key + 1
            ]);
        }
        //
        Menu::find($id)->delete();

        Alert::success('Opération réussi', 'Success Message');
        return redirect()->route('menu.create');

        // return response()->json([
        //     'status' => 200,
        // ]);
    }
}
