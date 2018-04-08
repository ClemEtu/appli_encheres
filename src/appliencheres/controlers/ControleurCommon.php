<?php

namespace appliencheres\controlers;


class ControleurCommon
{
    public function getHeader(){
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/common/header.php';
    }

    public function getFooter(){
        $slim = \Slim\Slim::getInstance();
        include 'src/appliencheres/views/common/footer.php';
    }
}