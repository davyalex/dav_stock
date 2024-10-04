<?php

namespace App\Http\Controllers\backend\permission;

use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //

    public function index()
    {
        $modules_with_permissions = Module::with('permissions')->orderBy('name', 'ASC')->get();
        // $role = Role::get();
        // $permission = Permission::get();
        // $role_with_permission = Role::withWhereHas('permissions')->get();

        


        return view('backend.pages.permission.index', compact('modules_with_permissions'));
    }


    public function getPermissionOfModule($id)
    {
        $module = Module::findOrFail($id);
        $permission = Permission::where('module_name', $module['name'])->get();
        return response()->json($permission);
    }


    public function store(Request $request)
    {
        // dd($request->toArray());
        //get role
        $role = Role::findById($request['role']);
        //give permission to role
        foreach ($request['permissions'] as $key => $value) {
            $role->givePermissionTo($value);
        }

        Alert::success('Operation réussi', 'Success Message');
        return back();
    }
}
