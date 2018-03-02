<?php

include 'vendor/autoload.php';
use \conf\Eloquent;

session_start();
Eloquent::init('src/conf/conf.ini');
$app = new \Slim\Slim();

// page accueil

$app->get('/', function(){
    $controleur = new ControleurAccueil();
    $controleur->getAccueil();
})->name("/");

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