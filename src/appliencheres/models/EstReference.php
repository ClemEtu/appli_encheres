<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 08/04/2018
 * Time: 19:23
 */

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class EstReference extends Model
{
    protected $table = 'est_reference';
    protected $primaryKey = 'if_ref';
    public $timestamps=false;



}