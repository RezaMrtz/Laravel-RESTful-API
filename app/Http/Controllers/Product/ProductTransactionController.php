<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
    /* Calling auth middleware in apiController */
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index']);;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {

        $transactions = $product->transactions()->get();

        return $this->showAll($transactions);
    }
}
