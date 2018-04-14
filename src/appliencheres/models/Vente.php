<?php

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