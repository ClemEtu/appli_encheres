<?php

namespace conf;
use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function init($file){
        $db = new DB();
        $db->addConnection(parse_ini_file($file));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}