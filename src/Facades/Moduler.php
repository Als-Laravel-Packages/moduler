<?php

namespace Aldev\Moduler\Facades;

use Illuminate\Support\Facades\Facade;
use Aldev\Moduler\Moduler as MainApplication;

/**
 * The Moduler facade.
 *
 * @package aldev/module
 * @author  Al Lestaire Acasio <allestaire.acasio@gmail.com>
 */
class Moduler extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MainApplication::class;
    }
}
