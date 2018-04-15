<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 08/04/2018
 * Time: 19:22
 */

namespace appliencheres\models;
use Illuminate\Database\Eloquent\Model;

class Enchere extends Model
{
    protected $table = 'enchere';
    public $timestamps=false;
    protected $primaryKey = "idEnchere";

    public function encherisseur() {
        return $this->belongsTo('appliencheres\models\Utilisateur', 'pseudo');
    }

    public function vente() {
        return $this->belongsTo('appliencheres\models\Vente', 'idVente');
    }

}