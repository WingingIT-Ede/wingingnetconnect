<?php

namespace Wshovius\WingingNetConnect\Facades;

use Illuminate\Support\Facades\Facade;

class WingingNetConnect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wingingnetconnect';
    }
}
