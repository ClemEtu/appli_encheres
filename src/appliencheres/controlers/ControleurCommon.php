<?php

namespace appliencheres\controlers;


class ControleurCommon
{
    public function getHeader(){
        include 'src/appliencheres/views/common/header.php';
    }

    public function getFooter(){
        include 'src/appliencheres/views/common/footer.php';
    }
}