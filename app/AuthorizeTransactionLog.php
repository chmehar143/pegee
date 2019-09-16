<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizeTransactionLog extends Model
{
    //

    public static function getTransactionsToRetry()
    {
        return AuthorizeTransactionLog::where('is_processed', '=', 0)
            ->where('attempts', '<', 10)->get();
    }
}
