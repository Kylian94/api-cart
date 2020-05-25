<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        foreach ($carts as $cart) {
            $data = Product::find($cart->product_id);
            $product = json_decode($data);
            $cart->product = $product;
        }
        return response()->json($carts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->product_id != NULL) {
            $product = Product::find($request->product_id);

            if ($product) {
                $product = json_decode($product);
                $request->product = $product;

                $cart = new Cart;
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->save();
                return response()->json($cart);
            } else {
                abort(404, 'Product not found.');
            }
        } elseif ($request->quantity == NULL) {
            abort(422, 'Quantity is missing.');
        } else {
            abort(422, 'Product ID is missing.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    public function delete($id)
    {

        $carts = Cart::where('product_id', '=', $id)->get();
        //dd($carts);
        foreach ($carts as $cart) {
            $productId = $cart->product_id;
            if ($id == $productId) {
                //echo $cart->product_id;
                $cart->delete();
                return response('product cart deleted', '200');
            }

            if ($id != $cart->product_id) {
                abort(404, 'Product not found.');
            }
        }
        // if ($cart) {
        //     $cart->delete();
        //     return response('product cart deleted', 200);
        // } else {
        //     
        // }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $carts = Cart::all();
        foreach ($carts as $cart) {
            $cart->delete();
            return response('cart deleted', 200);
        }
    }
}
