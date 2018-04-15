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
        $produitsEnVente = Vente::select('idProduit')->distinct()->where('statut','=',0)->get()->toArray();
        $refs = EstReference::all()->toArray();
        $motsCles = [];
        //var_dump($produitsEnVente);
        foreach ($refs as $ref){
            foreach ($produitsEnVente as $produit){
                if(in_array($ref['idProduit'], $produit)){
                    array_push($motsCles, $ref['libelleMotCle']);
                }
            }

        }
        $motsCles = array_unique($motsCles);
        asort($motsCles);
        include 'src/appliencheres/views/produit/motsCles.php';
    }

    public function getProduits($libelle){
        $slim = \Slim\Slim::getInstance();

        $produits = [];
        $references = EstReference::where('libelleMotCle',$libelle)->orderBy('libelleMotCle','ASC')->get();

        foreach ($references as $ref) {
            $produit = Produit::where('idProduit', '=', $ref['idProduit'])->first();
            $vente = Vente::where('idProduit', $produit['idProduit'])->where('statut',0)->first();
            if(isset($vente)){
                array_push($produits, $produit);
            }
        }

        include 'src/appliencheres/views/produit/produits.php';
    }

    public function getVente($idProduit) {
        $slim = \Slim\Slim::getInstance();

        $produit = Produit::where('idProduit',$idProduit)->first();
        $vente = Vente::where('idProduit',$idProduit)->where('statut', 0)->first();
        $encherePlusElevee = Enchere::where('idEnchere', $vente['idEnchereMax'])->first();
        if (isset($encherePlusElevee)){
            $montantEnchere = $encherePlusElevee['montant'];
        }
        else{
            $montantEnchere = $vente['prixDepart'];
        }
        include 'src/appliencheres/views/produit/vente.php';
    }

    public function getConfirmationEnchere($idProduit, $libelle){
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
            $enchere->pseudo =$_SESSION['userConnected']->pseudo;
            $vente = Vente::where('idProduit', $idProduit)->where('statut', 0)->first();
            $enchere->idVente =$vente->idVente;
            try {
                $enchere->save();
            }
            catch (\ErrorException $e){
                $_SESSION['errors'] = [];
                array_push($_SESSION['errors'], "Veuillez entrer un montant correct (supérieur au montant de l'enchère maximale et en ayant l'argent disponible sur votre compte !)");
                if(isset($libelle)){
                    header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/recherche/:libelle/:idProduit', ['idProduit' => $idProduit, 'libelle' => $libelle]));
                }
                else {
                    header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/:idProduit', ['idProduit' => $idProduit]));
                }
                exit;
            }
            $_SESSION['userConnected']->argentDispo -= $montant;
            $_SESSION['userConnected']->save();
            $_SESSION['messageConfirmation'] = "Votre enchère a ben été prise en compte !";
            if(isset($libelle)){
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/recherche/:libelle/:idProduit', ['idProduit' => $idProduit, 'libelle' => $libelle]));
            }
            else {
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/:idProduit', ['idProduit' => $idProduit]));
            }
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            if(isset($libelle)){
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/recherche/:libelle/:idProduit', ['idProduit' => $idProduit, 'libelle' => $libelle]));
            }
            else {
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/:idProduit', ['idProduit' => $idProduit]));
            }
            exit;
        }

    }

}