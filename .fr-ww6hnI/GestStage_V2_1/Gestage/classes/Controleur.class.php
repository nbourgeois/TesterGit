<?php

abstract class Controleur {

    protected $vue;

    function setVue($vue) {
        $this->vue = $vue;
    }

}