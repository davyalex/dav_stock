<?php

namespace App\Http\Controllers\backend\module;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    //


    public function index()
    {

        $data_module = Module::get();
        $data_module->sortBy('name');


        // $title = 'Delete User!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        return view('backend.pages.module.index', compact('data_module'));
    }


    public function store(Request $request)
    {





        $data_module = Module::firstOrCreate([
            'name' => $request['name'],
        ]);


        if ($data_module) {
            //request validation .......
            $permissions = [
                '0' => 'ajouter-' . $request['name'],
                '1' => 'voir-' . $request['name'],
                '2' => 'modifier-' . $request['name'],
                '3' => 'supprimer-' . $request['name']
            ];

            foreach ($permissions as $value) {
                Permission::firstOrCreate([
                    'name' => $value,
                    'module_name' => $request['name'],
                    'guard_name' => 'web',
                ]);
            }
        }

        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        //suppression  des permission pour une nouvelle insertion
        $module = Module::find($id);
        Permission::where('module_name', $module['name'])->delete();

        $data_page = Module::find($id)->update([
            'name' => $request['name'],
        ]);

        $permissions = [
            '0' => 'ajouter-' . $request['name'],
            '1' => 'voir-' . $request['name'],
            '2' => 'modifier-' . $request['name'],
            '3' => 'supprimer-' . $request['name']
        ];


        foreach ($permissions as $value) {
            Permission::firstOrCreate([
                'name' => $value,
                'module_name' => $request['name'],
                'guard_name' => 'web',
            ]);
        }

        // $data = Permission::where('module_name', $module['name'])->get();
        // dd($data);




        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {

        //supprimer les permissions associé au module
        $module = Module::find($id);
        Permission::where('module_name', $module['name'])->delete();


        Module::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
