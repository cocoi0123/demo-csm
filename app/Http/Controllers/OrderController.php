<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User_product;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function approvedOrder(Request $request, string $id)
    {

        $Order =  Order::where('id', $id)->first();
        if ($Order) {
            $Order->pay_status = $request->pay_status;
            $Order->save();

            if ($Order->pay_status == 'Yes') {

                //add user product
                $User_product = new User_product();
                $User_product->user_id = $Order->user_id;
                $User_product->product_id = $Order->product_id;
                $User_product->save();

                //update stock product
                $Product = Product::where('id', $Order->product_id)->first();
                $Product->qty -= 1;
                $Product->save();
            }
        }

        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Order,
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $slip = $request->slip;

        $Order = new Order();

        $Order->user_id = $user_id;
        $Order->product_id = $product_id;
        $Order->code = $this->genCode($Order, 'OR', '0000000');
        $Order->date = date('Y-m-d');

        //
        if ($slip) {
            $Order->slip = $this->uploadFiles($slip, '/files/order/');
        }

        $Order->pay_date = date('Y-m-d H:i:s');

        $Order->save();


        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Order,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Order = Order::where('id', $id)->first();

        if ($Order) {
            //
        }
        return response()->json([
            'code' => strval(200),
            'status' => true,
            'message' => 'success',
            'data' => $Order,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
