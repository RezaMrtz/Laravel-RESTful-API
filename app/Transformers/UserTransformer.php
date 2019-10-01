<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identificator'=> (int)$user->id,
            'name'=>(string)$user->name,
            'email'=>(string)$user->email,
            'isVerified'=>($user->admin == 'true'),
            'creationDate'=>$user->created_at,
            'lastChange'=>$user->updated_at,
            'deletedDate'=>isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }
}
