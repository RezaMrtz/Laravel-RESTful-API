<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;

class BuyerTransactionController extends ApiController
{
    /* Calling auth middleware in apiController */
    public function __construct()
    {
        $this->middleware('transform.input'.TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchased-product')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }
}
