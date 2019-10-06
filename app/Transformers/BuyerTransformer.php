<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identificator' => (int) $buyer->id,
            'name' => (string) $buyer->name,
            'email' => (string) $buyer->email,
            'isVerified' => ($buyer->admin == 'true'),
            'creationDate' => (string) $buyer->created_at,
            'lastChange' => (string) $buyer->updated_at,
            'deletedDate' => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,

            /* HATEOAS (Hypermedia as the Engine of Application State) */
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel' => 'sellers',
                    'href' => route('sellers.index', $buyer->seller_id),
                ],
                [
                    'rel' => 'buyers.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $buyer->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificator' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'admin',
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
            'name' => 'name',
            'email' =>  'email',
            'isVerified' =>  'admin',
            'created_at' => 'creationDate',
            'updated_at' =>  'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
