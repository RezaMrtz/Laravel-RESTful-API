<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
    /* Calling auth middleware in apiController */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller = Seller::has('products')->get();

        return $this->showAll($seller);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
    //     return response()->json(['data' => $seller, 'code' => 200], 200);
        return $this->showOne($seller);
    }
}
