<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionBackupController extends Controller
{

    public function create(Request $request)
    {
        // dd($request->all());
        $code = $request->code;
        $name = $request->name;
        $create_by = $request->create_by;

        $Permission = new Permission();

        $Permission->code = $code;
        $Permission->name = $name;
        $Permission->create_by = $create_by;
        $Permission->save();


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Permission,
        ], 200);
    }

    public function get(Request $request)
    {
        $code = $request->code;

        $Permission = Permission::where('code', $code)
            ->get();

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

    public function getById($id)
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

    public function update(Request $request, $id)
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

    public function delete($id)
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
