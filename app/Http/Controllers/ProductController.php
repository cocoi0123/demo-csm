<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product_type_id = $request->product_type_id;

        $product = Product::orderby('id');

        if ($product_type_id) {
            $product->where('product_type_id', $product_type_id);
        }

        $Product = $product->get();

        if ($Product->isNotEmpty()) {

            for ($i = 0; $i < count($Product); $i++) {
                $Product[$i]->No = 1;
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product,
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
        $product_type_id = $request->product_type_id;
        $code = $request->code;
        $name = $request->name;

        $price = $request->price;
        $cost = $request->cost;
        $detail = $request->detail;

        $image = $request->image;
        $file = $request->file;

        $qty = $request->qty;

        $create_by = $request->create_by;

        $Product = new Product();

        $Product->product_type_id = $product_type_id;
        $Product->code = $code;
        $Product->name = $name;
        $Product->price = $price;
        $Product->cost = $cost;
        $Product->detail = $detail;
        $Product->qty = $qty;

        if ($image) {
            $Product->image = $this->uploadFiles($image, '/files/product/');
        }

        if ($file) {
            $Product->file = $this->uploadFiles($file, '/files/product/');
        }

        $Product->create_by = $create_by;
        $Product->save();


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Product = Product::where('id', $id)->first();

        if ($Product) {
            //
        }
        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product,
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
    public function update(Request $request)
    {

        $id = $request->id;
        $product_type_id = $request->product_type_id;
        $code = $request->code;
        $name = $request->name;

        $price = $request->price;
        $cost = $request->cost;
        $detail = $request->detail;
        $qty = $request->qty;

        $image = $request->image;
        $file = $request->file;

        $update_by = $request->update_by;

        $Product = Product::where('id', $id)->first();

        if ($Product) {
            $Product->product_type_id = $product_type_id;
            $Product->code = $code;
            $Product->name = $name;
            $Product->price = $price;
            $Product->cost = $cost;
            $Product->qty = $qty;
            $Product->detail = $detail;

            if ($image) {
                $Product->image = $this->uploadFiles($image, '/files/product/');
            }

            if ($file) {
                $Product->file = $this->uploadFiles($file, '/files/product/');
            }
            $Product->update_by = $update_by;
            $Product->save();
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Product = Product::where('id', $id)->first();

        if ($Product) {
            $Product->delete();
        }


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Product,
        ], 200);
    }
}
