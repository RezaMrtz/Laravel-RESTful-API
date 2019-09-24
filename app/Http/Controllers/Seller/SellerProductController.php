<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Product, App\User, App\Seller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        // $products = $seller->products()->get();   has the same result

        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer | min:1',
            'status'=> 'in:'. Product::AVAILABLE_PRODUCT. ',' .Product::UNAVAILABLE_PRODUCT,
            'image' => 'image'
        ];

        $this->validate($request, $rules);

        $this->checkSeller($seller, $product);

        if ($request->has('status'))
        {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() == 0)
            {
                return $this->errorResponse('An active product must have at least ONE category', 409);
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $product->save();

        return $this-> showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();

        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller, Product $product) {

        if ($product->id != $product->seller_id) {

            throw new HttpException(422, 'The specified seller is not the actual seller of the product');

        }
    }
}
