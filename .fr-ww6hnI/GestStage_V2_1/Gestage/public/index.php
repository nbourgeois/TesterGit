<?php
require("../includes/fonctions.inc.php");
//recherche du nom du controleur
$nomControleur= getRequest("controleur", "accueil");

//recherche du nom de l'action
$action= getRequest("action", "index");

//creation de l'instance de la vue
$vue=new Vue($nomControleur,$action);

$nomClasseControleur= getNomClasse('C',$nomControleur); 
//creation de l'instance de controleur
$objetControleur=new $nomClasseControleur();
$objetControleur->setVue($vue);
$objetControleur->$action();