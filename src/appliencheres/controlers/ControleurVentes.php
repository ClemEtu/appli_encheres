<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 15/04/2018
 * Time: 11:55
 */

namespace appliencheres\controlers;


use appliencheres\models\Enchere;
use appliencheres\models\EstReference;
use appliencheres\models\MotCle;
use appliencheres\models\Produit;
use appliencheres\models\Vente;

class ControleurVentes
{

    public function getInfoVentes(){
        $slim = \Slim\Slim::getInstance();
        if (isset($_SESSION['userConnected'])){
            $produits = Produit::where('pseudo_est_propose',$_SESSION['userConnected']->pseudo)->get();
            $produitsVendus = [];
            $produitsNonVendus = [];
            $produitsEnCours = [];
            $encheresPlusElevees = [];
            foreach ($produits as $produit){
                $vente = Vente::where('idProduit',$produit['idProduit'])->where('statut',2)->first();
                if(isset($vente)){
                    array_push($produitsVendus, $produit);
                    $enchereMax = Enchere::where('idEnchere', $vente['idEnchereMax'])->first();
                    if(isset($enchereMax)){
                        $encheresPlusElevees[$vente['idProduit']] = $enchereMax;
                    }
                }
                else{
                    $vente = Vente::where('idProduit',$produit['idProduit'])->where('statut',0)->first();
                    if(isset($vente)){
                        array_push($produitsEnCours, $produit);
                        $enchereMax = Enchere::where('idEnchere', $vente['idEnchereMax'])->first();
                        if(isset($enchereMax)){
                            $encheresPlusElevees[$vente['idProduit']] = $enchereMax;
                        }
                    }
                    else{
                        $vente = Vente::where('idProduit',$produit['idProduit'])->where('statut',1)->orwhere('statut',3)->first();
                        if(isset($vente)){
                            array_push($produitsNonVendus, $produit);
                        }
                    }
                }
            }
        }
            include "src/appliencheres/views/vente/vente.php";
    }

    public function remettreEnVente($idProduit){
        $produit = Produit::where('idProduit',$idProduit)->first();

        include "src/appliencheres/views/vente/remiseEnVente.php";
    }

    public function traiterRemiseEnVente($idProduit){
        $produit = Produit::where('idProduit',$idProduit)->first();
        $slim = \Slim\Slim::getInstance();

        $dateLimite = $_POST['dateFin'];
        $prixDep = 0;
        $prixFixe = 0;
        $errors = [];

        if (password_verify($_POST['mdp'], $_SESSION['userConnected']->mdp)) {
            if ($_POST['prixDepart'] > 0 && $_POST['prixDepart'] == filter_var($_POST['prixDepart'], FILTER_SANITIZE_NUMBER_INT)) {
                $prixDep = $_POST['prixDepart'];
                if ($_POST['prixFixe'] > 0 && $_POST['prixFixe'] == filter_var($_POST['prixFixe'], FILTER_SANITIZE_NUMBER_INT)) {
                    $prixFixe = $_POST['prixFixe'];
                } else {
                    array_push($errors, "Veuillez entrer un prix de fin valide (entier et supérieur à 0)");
                }
            } else {
                array_push($errors, "Veuillez entrer un prix de départ valide (entier et supérieur à 0)");
            }
        } else {
            array_push($errors, "Veuillez entrer le mot de passe associé à votre compte utilisateur.");
        }

        if (sizeof($errors) == 0) {
            $vente = new Vente();
            $vente->prixDepart = $prixDep;
            $vente->prixFixe = $prixFixe;
            $vente->dateLimite = $dateLimite;
            $vente->idProduit = $idProduit;
            try {
                $vente->save();
            }
            catch (\ErrorException $e){
                $_SESSION['errors'] = [];
                array_push($_SESSION['errors'], "Veuillez entrer des informations correctes pour la vente (le prix limite doit être supérieur au prix de départ et la date de fin doit être postérieure à aujourd'hui) ");
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/remiseEnVente/:idProduit', ['idProduit' => $idProduit]));
                exit;
            }
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/:idProduit', ['idProduit' => $idProduit]));
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/remiseEnVente/:idProduit', ['idProduit' => $idProduit]));
            exit;
        }
    }

    public function mettreEnVente(){
        include 'src/appliencheres/views/vente/miseEnVente.php';
    }

    public function traiterMiseEnVente(){
        $slim = \Slim\Slim::getInstance();
        $nomProduit = $_POST['nomProduit'];
        $description = $_POST['description'];
        $motsCles = explode(',',$_POST['motsCles']);
        $imageProduit = $_POST['img'];
        $dateLimite = $_POST['dateFin'];
        $prixDep = 0;
        $prixFixe = 0;
        $errors = [];

        if (password_verify($_POST['mdp'], $_SESSION['userConnected']->mdp)) {
            if ($_POST['prixDepart'] > 0 && $_POST['prixDepart'] == filter_var($_POST['prixDepart'], FILTER_SANITIZE_NUMBER_INT)) {
                $prixDep = $_POST['prixDepart'];
                if ($_POST['prixFixe'] > 0 && $_POST['prixFixe'] == filter_var($_POST['prixFixe'], FILTER_SANITIZE_NUMBER_INT)) {
                    $prixFixe = $_POST['prixFixe'];
                } else {
                    array_push($errors, "Veuillez entrer un prix de fin valide (entier et supérieur à 0)");
                }
            } else {
                array_push($errors, "Veuillez entrer un prix de départ valide (entier et supérieur à 0)");
            }
        } else {
            array_push($errors, "Veuillez entrer le mot de passe associé à votre compte utilisateur.");
        }

        if (sizeof($errors) == 0) {
            $keysWords = [];
            foreach ($motsCles as $motCle){
                $search = MotCle::where('libelleMotCle',$motCle)->first();
                if(!isset($search)){
                    $keyWord = new MotCle();
                    $keyWord->libelleMotCle = $motCle;
                    $keyWord->save();
                }
                array_push($keysWords, $motCle);
            }
            $produit = new Produit();
            $produit->nomProduit = $nomProduit;
            $produit->description = $description;
            $produit->image = $imageProduit;
            $produit->pseudo_est_propose = $_SESSION['userConnected']->pseudo;
            $produit->save();
            foreach ($keysWords as $keyWord){
                $produit->motCles()->attach($keyWord);
                /*$er = new EstReference();
                $er->libelleMotCle = $keyWord;
                $er->idProduit = $produit['idProduit'];
                $er->save();*/
            }
            $vente = new Vente();
            $vente->prixDepart = $prixDep;
            $vente->prixFixe = $prixFixe;
            $vente->dateLimite = $dateLimite;
            $vente->idProduit = $produit['idProduit'];
            try {
                $vente->save();
            }
            catch (\ErrorException $e){
                $_SESSION['errors'] = [];
                array_push($_SESSION['errors'], "Veuillez entrer des informations correctes pour la vente (le prix limite doit être supérieur au prix de départ et la date de fin doit être postérieure à aujourd'hui) ");
                header('Location: ' . \Slim\Slim::getInstance()->urlFor('/miseEnVente'));
                exit;
            }
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/produits/:idProduit', ['idProduit' => $produit['idProduit']]));
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/miseEnVente'));
            exit;
        }

    }
}