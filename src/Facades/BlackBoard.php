<?php

namespace uisits\blackboardintegration\Facades;

use Illuminate\Support\Facades\Facade;

class BlackBoard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blackboard-facade';
    }
}
