<?php

namespace App\Exceptions;

use Exception;

class CurrencyLayerHttp extends Exception
{
    

    public static function responseNotOk():CurrencyLayerHttp{
        return new CurrencyLayerHttp("Currency layer api response code not ok!",500);
    }
    public static function returnedPairNotFound(string $pair):CurrencyLayerHttp{
        return new CurrencyLayerHttp("Currency layer api returned pair $pair not found in db!",500);
    }
}
