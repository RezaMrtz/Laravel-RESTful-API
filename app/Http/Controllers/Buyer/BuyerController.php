<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;


class BuyerController extends ApiController
{
    /* Calling auth middleware in apiController */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
    }

    public function index()
    {
        $buyer = Buyer::has('transactions')->get();

        return $this->showAll($buyer);
    }

    public function show($id)
    {
        $buyer = Buyer::has('transactions')->findOrFail($id);

        return $this->showOne($buyer);
    }
}
