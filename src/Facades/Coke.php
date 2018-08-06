<?php
/**
 * Created by PhpStorm.
 * User: shadow_m2
 * Date: 8/5/18
 * Time: 2:14 PM
 */

namespace Shadow\Coke\Facades;
use Illuminate\Support\Facades\Facade;

class Coke extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'coke';
    }
}