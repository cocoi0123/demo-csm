<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public $key = "csm_key";

    public function genToken($id, $name)
    {
        $payload = [
            "iss" => "csm",
            "aud" => $id,
            "lun" => $name,
            "iat" => Carbon::now()->timestamp,
            // "exp" => Carbon::now()->timestamp + 86400,
            "exp" => Carbon::now()->timestamp + 31556926,
            "nbf" => Carbon::now()->timestamp,
        ];

        $token = JWT::encode($payload, $this->key);

        return $token;
    }


    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $User = User::where('username', $username)
            ->where('password', md5($password))
            ->first();


        if ($User) {

            return response()->json([
                'code' => strval(200),
                'status' => true,
                'message' => 'login success',
                'data' => ['user' => $User, 'token' => $this->genToken($User->id, $User)],
            ], 200);
        } else {
            return response()->json([
                'code' => strval(404),
                'status' => false,
                'message' => 'login fail, Username or Password invalid',
                'data' => null,
            ], 404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $User = User::with('permission')->get();

        if ($User->isNotEmpty()) {

            for ($i = 0; $i < count($User); $i++) {
                // $User[$i]->No = 1;
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $User,
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

        $permission_id = $request->permission_id;
        $code = $request->code;
        $username = $request->username;
        $password = $request->password;
        $name = $request->name;
        $email = $request->email;
        $tel = $request->tel;
        $register_date = $request->register_date;
        $create_by = $request->create_by;

        $User = new User();

        $User->permission_id = $permission_id;
        $User->code = $code;
        $User->username = $username;
        $User->password = md5($password);
        $User->name = $name;
        $User->email = $email;
        $User->tel = $tel;
        $User->register_date = $register_date;
        $User->create_by = $create_by;

        $User->save();


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $User,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function import(Request $request)
    {
        $file = request()->file('file');
        $fileName = $file->getClientOriginalName();

        $Sheet = [];

        $import = new UserImport();
        $data = Excel::toArray($import, $file)[0];

        if (count($data) > 0) {

            // dd($data);

            for ($i = 0; $i < count($data); $i++) {
                $permission_id = trim($data[$i][0]);
                $code = trim($data[$i][1]);
                $username = trim($data[$i][2]);
                $password = trim($data[$i][3]);
                $name = trim($data[$i][4]);
                $email = trim($data[$i][5]);
                $tel = trim($data[$i][6]);
                $register_date = trim($data[$i][7]);


                $row = $i + 2;

                if ($code == '') {
                    return $this->returnErrorData('ข้อมูล excel แถวที่ ' . $row . ' กรุณาระบุรหัสให้เรียบร้อย', 404);
                } else if ($permission_id == '') {
                    return $this->returnErrorData('ข้อมูล excel แถวที่ ' . $row . ' กรุณาระบุสิทธิ์การใช้งานให้เรียบร้อย', 404);
                } else if ($username == '') {
                    return $this->returnErrorData('ข้อมูล excel แถวที่ ' . $row . ' กรุณาระบุชื่อผู้ใช้งานให้เรียบร้อย', 404);
                } else if ($password == '') {
                    return $this->returnErrorData('ข้อมูล excel แถวที่ ' . $row . ' กรุณาระบุรหัสผ่านให้เรียบร้อย', 404);
                } else if ($name == '') {
                    return $this->returnErrorData('ข้อมูล excel แถวที่ ' . $row . ' กรุณาระบุชื่อให้เรียบร้อย', 404);
                }

                //////////////////////////// check name //////////////////////////
                $checkName = User::where('code', $code)
                    ->first();

                if ($checkName) {

                    //update
                    $checkName->permission_id = $permission_id;
                    $checkName->code = $code;
                    $checkName->username = $username;
                    $checkName->password = md5($password);
                    $checkName->name = $name;
                    $checkName->email = $email;
                    $checkName->tel = $tel;
                    $checkName->register_date = $register_date;

                    $checkName->save();
                } else {

                    //new
                    $User = new User();
                    $User->permission_id = $permission_id;
                    $User->code = $code;
                    $User->username = $username;
                    $User->password = md5($password);
                    $User->name = $name;
                    $User->email = $email;
                    $User->tel = $tel;
                    $User->register_date = $register_date;

                    $User->create_by = 'admin';
                    $User->updated_at = Carbon::now()->toDateTimeString();
                    $User->save();
                }
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => null,
        ], 200);
    }


    public function export(Request $request)
    {
        $data = User::get()->toArray();

        if (!empty($data)) {

            for ($i = 0; $i < count($data); $i++) {


                $export_data[] = array(
                    'permission_id' => trim($data[$i]['permission_id']),
                    'code' => trim($data[$i]['code']),
                    'username' => trim($data[$i]['username']),
                    'name' => trim($data[$i]['name']),
                    'email' => trim($data[$i]['email']),
                    'tel' => trim($data[$i]['tel']),
                    'register_date' => trim($data[$i]['register_date'])
                );
            }

            $result = new UserExport($export_data);
            return Excel::download($result, 'user.xlsx');
        } else {

            $export_data[] = array(
                'permission_id' => null,
                'code' => null,
                'username' => null,
                'name' => null,
                'email' => null,
                'tel' => null,
                'register_date' => null,
            );

            $result = new UserExport($export_data);
            return Excel::download($result, 'user.xlsx');
        }
    }
}
