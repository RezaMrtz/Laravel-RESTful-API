<?php

namespace App\Http\Controllers\Product;

use App\User;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('can:purchase,buyer')->only('store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductBuyerTransaction $request, Product $product, User $buyer)
    {
        $validate = $request->validate();
        
        if ($buyer->id == $product->seller_id ) {
            return $this->errorResponse('The buyer must be different from the user', 409);
        }

        if (!$buyer->isVerified())
        {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        if ($product->seller->isVerified()) //$product->seller is a relationship
        {
            return $this->errorResponse('The seller must be a verified user', 409);
        }

        if (!$product->isAvailable())
        {
            return $this->errorResponse('The product is not available', 409);
        }

        if ($product->quantity < $request->quantity)
        {
            return $this->errorResponse('The product does not have enough units for this transaction', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {

            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction);

        });

    }
}
