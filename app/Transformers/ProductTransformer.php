<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identificator' => (int) $product->id,
            'title' => (string) $product->name,
            'details' => (string) $product->description,
            'stock' => (int) $product->quantity,
            'situation' => (int) $product->status,
            'picture' => url("img/{$product->image}"),
            'seller' => (int) $product->seller_id,
            'creationDate' => (string) $product->created_at,
            'lastChange' => (string) $product->updated_at,
            'deletedDate' => isset($product->deleted_at) ? (string) $product->deleted_at : null,

            /* HATEOAS (Hypermedia as the Engine of Application State) */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $product->seller_id),
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id),
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('categories.transactions.index', $product->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificator' => 'id',
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => (int) 'seller_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttribute($index)
    {
        $attributes = [
            'identificator' => 'id',
            'id' => 'identificator',
            'name' => 'title',
            'description' => 'details',
            'image' =>  'picture',
            'seller_id' =>  (int) 'seller',
            'created_at' => 'creationDate',
            'updated_at' =>  'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
