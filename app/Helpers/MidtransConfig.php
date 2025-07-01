<?php

namespace App\Helpers;

use Midtrans\Config;

class MidtransConfig
{
    public static function config()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // true jika sudah live
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
