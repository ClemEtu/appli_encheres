<?php

include 'vendor/autoload.php';
use \conf\Eloquent;
use \appliencheres\controlers\ControleurAccueil;
use \appliencheres\controlers\ControleurCommon;
use \appliencheres\controlers\ControleurSimplePage;

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