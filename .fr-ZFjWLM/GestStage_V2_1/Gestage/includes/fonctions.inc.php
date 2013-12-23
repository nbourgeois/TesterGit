<?php

/**
 * __autoload
 * @param string $classe : charge une classe à la demande
 */
function __autoload($classe) {
    $suffixe = substr($classe, 0, 2);
    switch ($suffixe) {
        case "C_" :
            $chemin = "../controleurs/";
            break;
        case "M_" :
            $chemin = "../modeles/";
            break;
        default :
            $chemin = "../classes/";
            break;
    }
    $chemin = $chemin . $classe . '.class.php';
    if (file_exists($chemin)) {
        require_once($chemin);
    } else {
        exit('Le fichier <b>' . $chemin . '</b> n\existe pas.');
    }
}

/**
 * getNomClasse
 * @param string $typeClasse : le type de classe : 'C' => contrôleur ; 'V'=> vue ; 'M'=> modèle
 * @param string $suffixe : le nom de l'action ; exemple : 'afficher' , 'index', ...
 * @return string nom de classe 
 * exemple :  nomClasse('C','article') => 'C_Article'
 */
function getNomClasse($typeClasse, $suffixe) {
    // ucfirst(chaine) retourne la chaine avec son initiale en  majuscule
    return ucfirst($typeClasse) . '_' . ucfirst($suffixe);
}

/**
 * getRequest
 * Lire la valeur d'un paramètre de l'URL (GET) ou d'un formulaire (POST)
 * @param string $nomParametre : nom du paramètre à lire GET ou POST 
 * @param string $valeurDefaut : valeur par défaut s'il n'est pas défini
 * @return string : valeur lue ou bien par défaut
 */
function getRequest($nomParametre, $valeurDefaut) {
    $valeurParametre= null;
    if (isset($_REQUEST["$nomParametre"])) {
        $valeurParametre = $_REQUEST["$nomParametre"];
    } else {
        $valeurParametre = $valeurDefaut;
    }
    return $valeurParametre;
}

//fonction d'impretion 
function edition(){
    options =="Width=700,Height=700";
    windows.open("../includes/edition.php","edition",options);
    
}




?>

