<?php
/**
 * Created by PhpStorm.
 * User: Playe
 * Date: 14/04/2018
 * Time: 14:40
 */

namespace appliencheres\controlers;

use appliencheres\models\Enchere;
use appliencheres\models\EstReference;
use appliencheres\models\MotCle;
use appliencheres\models\Produit;
use appliencheres\models\Vente;

class ControleurProduit
{
    public function getMotsCles(){
        $slim = \Slim\Slim::getInstance();

        $motsCles = MotCle::all()->toArray();

        include 'src/appliencheres/views/produit/motsCles.php';
    }

    public function getProduits($libelle){
        $slim = \Slim\Slim::getInstance();

        $produits = [];
        $references = EstReference::where('libelleMotCle',$libelle)->get();

        foreach ($references as $ref) {
            array_push($produits, Produit::where('idProduit', '=', $ref['idProduit'])->first());
        }

        include 'src/appliencheres/views/produit/produits.php';
    }

    public function getVente($idProduit) {
        $slim = \Slim\Slim::getInstance();

        $produit = Produit::where('idProduit',$idProduit)->first();
        $vente = Vente::where('idProduit',$idProduit)->where('statut', 0)->first();
        $encherePlusElevee = Enchere::where('idVente', $vente['idVente'])->first();
        if (isset($encherePlusElevee)){
            $montantEnchere = $encherePlusElevee['montant'];
        }
        else{
            $montantEnchere = $vente['prixDepart'];
        }
        include 'src/appliencheres/views/produit/vente.php';
    }

    public function getConfirmationEnchere($idProduit){
        $slim = \Slim\Slim::getInstance();

        $montant = 0;
        $errors = [];

        if (password_verify($_POST['mdp'], $_SESSION['userConnected']->mdp)) {
            if ($_POST['montant'] > 0 && $_POST['montant'] == filter_var($_POST['montant'], FILTER_SANITIZE_NUMBER_INT)) {
                $montant = $_POST['montant'];
            } else {
                array_push($errors, "Veuillez entrer un montant valide (entier et supérieur à 0)");
            }
        } else {
            array_push($errors, "Veuillez entrer le mot de passe associé à votre compte utilisateur.");
        }

        if (sizeof($errors) == 0) {
            $enchere = new Enchere();
            $enchere->montant = $montant;
            $enchere->pseudo = $_SESSION['userConnected']->pseudo;
            $vente = Vente::where('idProduit', $idProduit)->where('statut', 0)->first();
            $enchere->idVente = $vente->idVente;
            $enchere->save();
            $messageConfirmation = "Vous enchère a ben été prise en compte !";
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/recherche/:libelle/:idProduit'));
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/recherche/:libelle/:idProduit'));
            exit;
        }

    }

}