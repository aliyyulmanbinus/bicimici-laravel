<?php

namespace App\Helpers;

use App\Models\Transaction;

class TransactionHelper
{
    public static function generateUniqueTrxId(): string
    {
        $prefix = 'BICIMICI'; // You can change this prefix as needed
        do {
            $randomString = $prefix . mt_rand(1000, 9999); // BICIMICI1293918
        } while (Transaction::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }
}
