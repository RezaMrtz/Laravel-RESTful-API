<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryBuyerController extends ApiController
{
    /* Calling auth middleware in apiController */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $this->allowedAdminAction();

        $buyer = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();

        return $this->showAll($buyer);
    }
}
