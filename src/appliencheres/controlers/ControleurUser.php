<?php
namespace appliencheres\controlers;


use appliencheres\models\Enchere;
use appliencheres\models\Produit;
use appliencheres\models\Utilisateur;
use appliencheres\models\Vente;

class ControleurUser
{
    public function afficherInfoUtilisateur(){
        $slim = \Slim\Slim::getInstance();
        $encheres = Enchere::orderBy('montant','DESC')->where('pseudo',$_SESSION['userConnected']->pseudo)->get();
        $encheresPlusElevees = [];
        $produits = [];
        $ventes = [];
        foreach($encheres as $enchere){
            if(!isset($encheresPlusElevees[$enchere['idVente']])){
                $vente = Vente::where('idVente',$enchere['idVente'])->where('statut',0)->first();
                if(isset($vente)) {
                    $encheresPlusElevees[$enchere['idVente']] = $enchere;
                    $produit = Produit::where('idProduit', $vente['idProduit'])->first();
                    $produits[$enchere['idVente']] = $produit;
                    $ventes[$enchere['idVente']] = $vente;
                }
            }
        }

        include 'src/appliencheres/views/user/info.php';
    }

    public function getInfoPaiement(){
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/user/rechargerCompte.php';
    }

    public function rechargerCompte(){
        $slim = \Slim\Slim::getInstance();

        $slim = \Slim\Slim::getInstance();
        $mdp = "";
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
            $_SESSION['userConnected']->solde += $montant;
            $_SESSION['userConnected']->argentDispo += $montant;
            $_SESSION['userConnected']->save();
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/user/info'));
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ' . \Slim\Slim::getInstance()->urlFor('/user/rechargerCompte'));
            exit;
        }
    }
}