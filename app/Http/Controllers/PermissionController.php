<?php

namespace App\Http\Controllers;

use App\Models\Menu_permission;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function getUserPermission(Request $request)
    {

        $user_id = $request->user_id;

        $User =  User::where('id', $user_id)->first();

        $Menu_permission = Menu_permission::where('permission_id', $User->permission_id)
            ->get();

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Menu_permission,
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */

    //get
    public function index(Request $request)
    {
        $code = $request->code;

        $permission = Permission::orderby('id');

        if ($code) {
            $permission->where('code', $code);
        }

        $Permission = $permission->get();

        if ($Permission->isNotEmpty()) {

            for ($i = 0; $i < count($Permission); $i++) {
                $Permission[$i]->No = 1;
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $code = $request->code;
        $name = $request->name;
        $create_by = $request->create_by;

        $menu = $request->menu;
        // dd($menu);

        $Permission = new Permission();

        $Permission->code = $code;
        $Permission->name = $name;
        $Permission->create_by = $create_by;
        $Permission->save();


        //add menu
        for ($i = 0; $i < count($menu); $i++) {

            $Menu_permission =  new Menu_permission();

            $Menu_permission->permission_id =  $Permission->id;
            $Menu_permission->menu_id =  $menu[$i]['menu_id'];
            $Menu_permission->view = $menu[$i]['view'];
            $Menu_permission->save = $menu[$i]['save'];
            $Menu_permission->edit = $menu[$i]['edit'];
            $Menu_permission->delete = $menu[$i]['delete'];
            $Menu_permission->save();
        }


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Permission = Permission::where('id', $id)->first();

        if ($Permission) {
            //
        }
        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $code = $request->code;
        $name = $request->name;
        $update_by = $request->update_by;

        $Permission = Permission::where('id', $id)->first();

        if ($Permission) {
            $Permission->code = $code;
            $Permission->name = $name;
            $Permission->update_by = $update_by;
            $Permission->save();
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Permission = Permission::where('id', $id)->first();

        if ($Permission) {
            $Permission->delete();
        }


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }
}
