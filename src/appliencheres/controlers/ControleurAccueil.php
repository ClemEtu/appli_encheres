<?php

namespace appliencheres\controlers;

class ControleurAccueil
{

    public function getAccueil() {
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/accueil.php';
    }

}