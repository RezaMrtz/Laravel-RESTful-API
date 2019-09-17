<?php

use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Transaction::truncate();

        factory(Transaction::class, 40)->create();
    }
}
