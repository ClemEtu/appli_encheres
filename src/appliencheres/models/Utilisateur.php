<?php

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'pseudo';
    public $timestamps=false;

    public function encheres() {
        return $this->hasMany('appliencheres\models\Enchere', 'pseudo');
    }

    public function aPropose() {
        return $this->hasMany('appliencheres\models\Produit', 'pseudo_est_propose');
    }

    public function aAchete() {
        return $this->hasMany('appliencheres\models\Produit', 'pseudo_est_achete');
    }
}