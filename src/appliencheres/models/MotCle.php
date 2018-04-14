<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 08/04/2018
 * Time: 19:23
 */

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class MotCle extends Model
{
    protected $table = 'motcle';
    public $timestamps=false;

    public function produits() {
        return $this->belongsToMany('appliencheres\models\Produit', 'produit','idProduit');
    }


}