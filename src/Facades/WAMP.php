<?php

namespace sonrac\WAMP\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class WAMP
 * WAMP facade.
 */
class WAMP extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'wampRouter';
    }
}
