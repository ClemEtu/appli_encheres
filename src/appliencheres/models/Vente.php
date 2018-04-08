<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 08/04/2018
 * Time: 19:24
 */

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $table = 'vente';
    public $timestamps=false;

    public function encheres() {
        return $this->hasMany('appliencheres\models\Enchere', 'idVente');
    }

    public function produit(){
        return $this->belongsTo('appliencheres\models\Produit', 'idProduit');
    }

}