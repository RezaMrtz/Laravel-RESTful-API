<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
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
