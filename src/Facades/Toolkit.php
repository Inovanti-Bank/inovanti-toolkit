<?php

namespace InovantiBank\Toolkit\Facades;

use Illuminate\Support\Facades\Facade;

class Toolkit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'toolkit';
    }
}
