<?php

include 'vendor/autoload.php';
use \conf\Eloquent;
use \appliencheres\controlers\ControleurAccueil;
use \appliencheres\controlers\ControleurCommon;
use \appliencheres\controlers\ControleurSimplePage;
use \appliencheres\controlers\ControleurUser;
use \appliencheres\controlers\ControleurProduit;
use \appliencheres\controlers\ControleurVentes;

session_start();
Eloquent::init('src/conf/conf.ini');
$app = new \Slim\Slim();

// page accueil

$app->get('/', function(){
    $controleur = new ControleurAccueil();
    $controleur->getAccueil();
})->name("/");

// simple page

$app->get('/simplePage/inscription', function (){
    $controleur = new ControleurSimplePage();
    $controleur->inscription();
})->name("/simplePage/inscription");

$app->post('/simplePage/inscription', function (){
    $controleur = new ControleurSimplePage();
    $controleur->inscrireUtilisateur();
})->name("POST/simplePage/inscription");

$app->get('/simplePage/connexion', function (){
    $controleur = new ControleurSimplePage();
    $controleur->connexion();
})->name('/simplePage/connexion');

$app->post('/simplePage/connexion', function (){
    $controleur = new ControleurSimplePage();
    $controleur->connecterUtilisateur();
})->name('POST/simplePage/connexion');

$app->get('/simplePage/deconnexion', function (){
    $controleur = new ControleurSimplePage();
    $controleur->deconnexion();
})->name('/simplePage/deconnexion');

// user

$app->get('/user/info', function (){
    $controleur = new ControleurUser();
    $controleur->afficherInfoUtilisateur();
})->name('/user/info');

$app->get('/user/rechargerCompte', function (){
    $controleur = new ControleurUser();
    $controleur->getInfoPaiement();
})->name('/user/rechargerCompte');

$app->post('/user/rechargerCompte', function (){
    $controleur = new ControleurUser();
    $controleur->rechargerCompte();
})->name('POST/user/rechargerCompte');

// produit

$app->get('/produits/recherche', function (){
    $controleur = new ControleurProduit();
    $controleur->getMotsCles();
})->name('/produits/recherche');

$app->get('/produits/recherche/:libelle', function ($libelle){
    $controleur = new ControleurProduit();
    $controleur->getProduits($libelle);
})->name('/produits/recherche/:libelle');

$app->get('/produits/recherche/:libelle/:idProduit', function ($libelle, $idProduit){
    $controleur = new ControleurProduit();
    $controleur->getVente($idProduit);
})->name('/produits/recherche/:libelle/:idProduit');

$app->post('/produits/recherche/:libelle/:idProduit', function ($libelle, $idProduit){
    $controleur = new ControleurProduit();
    $controleur->getConfirmationEnchere($idProduit,$libelle);
})->name('POST/produits/recherche/:libelle/:idProduit');


$app->get('/produits/:idProduit', function ($idProduit){
    $controleur = new ControleurProduit();
    $controleur->getVente($idProduit);
})->name('/produits/:idProduit');

$app->post('/produits/:idProduit', function ($idProduit){
    $controleur = new ControleurProduit();
    $controleur->getConfirmationEnchere($idProduit, null);
})->name('POST/produits/:idProduit');

//vente
$app->get('/user/ventes', function (){
    $controleur = new ControleurVentes();
    $controleur->getInfoVentes();
})->name('/user/ventes');

$app->get('/remiseEnVente/:idProduit', function ($idProduit){
    $controleur = new ControleurVentes();
    $controleur->remettreEnVente($idProduit);
})->name('/remiseEnVente/:idProduit');

$app->post('/remiseEnVente/:idProduit', function ($idProduit){
    $controleur = new ControleurVentes();
    $controleur->traiterRemiseEnVente($idProduit);
})->name('POST/remiseEnVente/:idProduit');

$app->get('/miseEnVente', function (){
    $controleur = new ControleurVentes();
    $controleur->mettreEnVente();
})->name('/miseEnVente');

$app->post('/miseEnVente', function (){
    $controleur = new ControleurVentes();
    $controleur->traiterMiseEnVente();
})->name('POST/miseEnVente');

// common

$app->hook('slim.before.dispatch', function () {
    $controleur = new ControleurCommon();
    $controleur->getHeader();
});
$app->hook('slim.after.dispatch', function () {
    $controleur = new ControleurCommon();
    $controleur->getFooter();
});

$app->run();