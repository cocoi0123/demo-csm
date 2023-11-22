<?php

namespace App\Http\Controllers;

use App\Models\Product_type;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $code = $request->code;

        $product_type = Product_type::orderby('id');

        if ($code) {
            $product_type->where('code', $code);
        }

        $Product_type = $product_type->get();

        if ($Product_type->isNotEmpty()) {

            for ($i = 0; $i < count($Product_type); $i++) {
                $Product_type[$i]->No = 1;
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product_type,
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
        $code = $request->code;
        $name = $request->name;
        $create_by = $request->create_by;

        $Product_type = new Product_type();

        $Product_type->code = $code;
        $Product_type->name = $name;
        $Product_type->create_by = $create_by;
        $Product_type->save();


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product_type,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Product_type = Product_type::where('id', $id)->first();

        if ($Product_type) {
            //
        }
        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product_type,
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

        $Product_type = Product_type::where('id', $id)->first();

        if ($Product_type) {
            $Product_type->code = $code;
            $Product_type->name = $name;
            $Product_type->update_by = $update_by;
            $Product_type->save();
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product_type,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Product_type = Product_type::where('id', $id)->first();

        if ($Product_type) {
            $Product_type->delete();
        }


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product_type,
        ], 200);
    }
}
