<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 08/04/2018
 * Time: 19:23
 */

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table = 'produit';
    protected $primaryKey = 'idProduit';
    public $timestamps=false;

    public function motCles() {
        //return $this->belongsToMany('appliencheres\models\MotCle', 'motCle', 'libelleMotCle');
        return $this->belongsToMany('appliencheres\models\MotCle', 'est_reference','idProduit', 'libelleMotCle');
    }

    public function ventes() {
        return $this->hasMany('appliencheres\models\Vente', 'idProduit');
    }

    public function vendeur() {
        return $this->belongsTo('appliencheres\models\Utilisateur', 'pseudo_est_propose');
    }

    public function acheteur() {
        return $this->belongsTo('appliencheres\models\Utilisateur', 'pseudo_est_achete');
    }
}