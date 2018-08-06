<?php
/**
 * Created by PhpStorm.
 * User: shadow_m2
 * Date: 8/5/18
 * Time: 1:54 PM
 */


$router = app()->router;

$router->get('/', function () {
   return 25;
});