<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller = Seller::has('products')->get();

        return response()->json(['data'=>$seller, 'code'=> 200], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = Seller::has('products')->findOrFail($id);

        return response()->json(['data' => $seller, 'code' => 200], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
