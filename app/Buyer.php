<?php

namespace App;
use App\Transaction;

class Buyer extends User
{
    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }
}
