<?php

define('DSN', 'mysql:host=localhost;dbname=GESTAGE');
define('USER', 'root');
define('MDP', '');

abstract class Modele {

    private $pdo;
    protected $nomClasseMetier = 'Enregistrement';
    protected $clePrimaire = 'num';

    /**
     * pdo
     * Crée un objet de type PDO et ouvre la connexion 
     * @return un objet de type PDO pour accéder à la base de données
     */
    function connecter() {
        if (!isset($this->pdo)) {
            /* Connexion à une base via PDO */
   
         try {
                $this->setPdo(new PDO(DSN, USER, MDP));
            } catch (PDOException $e) {
                echo 'Connexion échouée : ' . $e->getMessage();
            }
        }
        return $this->getPdo();
    }

    function deconnecter() {
        $this->setPdo(null);
    }

    /**
     * getAll
     * Lire tous les enregistrements d'une table
     * @return un tableau d'instances de la classe $this->nomClasseMetier
     */
    function getAll() {
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT * FROM " . $this->table . " ORDER BY " . $this->clePrimaire . " DESC";
        // Exécuter la requête
        $resultSet = $pdo->query($query);
        // FETCH_CLASS permet de retourner des enregistrements sous forme d'objets de la classe spécifiée
        // ici : $this->nomClasseMetier contient "Enregistrement"
        // La classe Enregistrement est une classe générique vide qui sera automatiquement affublée d'autant
        // d'attributs publics qu'il y a de colonnes dans le jeu d'enregistrements
        $retour = $resultSet->fetchAll(PDO::FETCH_CLASS, $this->nomClasseMetier);
        $this->deconnecter();
        return $retour;
    }


    /**
     * get
     * Lire un enregistrement d'après une valeur de clef primaire
     * @param $valeurClePrimaire
     * @return une instance de la classe $this->nomClasseMetier
     */
    function get($valeurClePrimaire) {
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->clePrimaire . " = ?";
        $queryPrepare = $pdo->prepare($query);
        // Spécifier le type de classe à instancier
        $queryPrepare->setFetchMode(PDO::FETCH_CLASS, $this->nomClasseMetier);
        // Exécuter la requête avec les valeurs des paramètres
        $retour = null;
        if ($queryPrepare->execute(array($valeurClePrimaire))) {
            $retour = $queryPrepare->fetch(PDO::FETCH_CLASS);
        }
        $this->deconnecter();
        return $retour;
    }
    
    // fonction qui permetra de connaitre le nombre fois qu'une Identité est déjà présente dans la base de donnée 
     function getCount($valeurACompter) {
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT COUNT(*) AS NB FROM " . $this->table . " WHERE ". $this->clePrimaire ."= ? ;";
        $queryPrepare = $pdo->prepare($query);
        // Spécifier le type de classe à instancier
        $queryPrepare->setFetchMode(PDO::FETCH_CLASS, $this->nomClasseMetier);
        // Exécuter la requête avec les valeurs des paramètres
        $retour = null;
        if ($queryPrepare->execute(array($valeurACompter))) {
            $retour = $queryPrepare->fetch(PDO::FETCH_CLASS);
        }
        $this->deconnecter();
        return $retour;
    }
    
    function getFromLogin($valeurLogin) {
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT * FROM " . $this->table . " WHERE LOGINUTILISATEUR = '" . $valeurLogin . "'";
        $queryPrepare = $pdo->prepare($query);
        // Spécifier le type de classe à instancier
        $queryPrepare->setFetchMode(PDO::FETCH_CLASS, $this->nomClasseMetier);
        // Exécuter la requête avec les valeurs des paramètres
        $retour = null;
        if ($queryPrepare->execute(array($valeurLogin))) {
            $retour = $queryPrepare->fetch(PDO::FETCH_CLASS);
        }
        $this->deconnecter();
        return $retour;
    }
    
    function getFromLoginValeursId($valeurLogin) {
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT * FROM " . $this->table . " E INNER JOIN SPECIALITE O ON IDSPECIALITE = IDSPECIALITE INNER JOIN ROLE R ON R.IDROLE = E.IDROLE WHERE LOGINUTILISATEUR = '" . $valeurLogin . "'";
        $queryPrepare = $pdo->prepare($query);
        // Spécifier le type de classe à instancier
        $queryPrepare->setFetchMode(PDO::FETCH_CLASS, $this->nomClasseMetier);
        // Exécuter la requête avec les valeurs des paramètres
        $retour = null;
        if ($queryPrepare->execute(array($valeurLogin))) {
            $retour = $queryPrepare->fetch(PDO::FETCH_CLASS);
        }
        $this->deconnecter();
        
        return $retour;
    }
    
    function getId($id, $table, $nomLibelle, $valeur){
        $pdo = $this->connecter();
        // Requête textuelle
        $query = "SELECT " . $id . " FROM " . $table . " WHERE " . $nomLibelle . " = '" . $valeur. "'";
        $resultSet = $pdo->query($query);
        // FETCH_CLASS permet de retourner des enregistrements sous forme d'objets de la classe spécifiée
        // ici : $this->nomClasseMetier contient "Enregistrement"
        // La classe Enregistrement est une classe générique vide qui sera automatiquement affublée d'autant
        // d'attributs publics qu'il y a de colonnes dans le jeu d'enregistrements
        $retour = $resultSet->fetchAll(PDO::FETCH_COLUMN, 0);
        $this->deconnecter();
        return $retour[0];
    }

    /**
     * update
     * Mise à jour d'un article
     * @param type $valeurClePrimaire (identifiant de la table)
     * @param type $tabChampsValeurs tableau associatif des couple (champ,valeur) à intégrer à la requête
     * @return boolean : succès/échec de la mise à jour
     */
    function update($valeurClePrimaire, $tabChampsValeurs) {
        $pdo = $this->connecter();
        // Construction de la requête textuelle
        $query = "UPDATE " . $this->table . " SET ";
        $tabValeurs = array();   // tableau des valeurs à construire pour l'exécution de la requête
        $numParam = 0;              // on compte les paramètres : le premier n'est pas précédé d'une virgule
        foreach ($tabChampsValeurs as $champ => $valeur) {
            if ($numParam != 0) {
                $query.= ", ";
            }
            $query.= $champ . " = ? ";  // ajout d'une clause du type champ = ?
            $tabValeurs[] = $valeur; // mémorisation de la valeur
            $numParam++;
        }
        // Clause de restriction
        $query.= " WHERE IDPERSONNE = ? ";
        $tabValeurs[] = $valeurClePrimaire;
        $queryPrepare = $pdo->prepare($query);
        // Exécution de la requête
        $retour = $queryPrepare->execute($tabValeurs);
        $this->deconnecter();
                
        return $retour;
    }
    //même que précédent mais pour une organisation
    function updateE($valeurClePrimaire, $tabChampsValeurs) {
        $pdo = $this->connecter();
        // Construction de la requête textuelle
        $query = "UPDATE " . $this->table . " SET ";
        $tabValeurs = array();   // tableau des valeurs à construire pour l'exécution de la requête
        $numParam = 0;              // on compte les paramètres : le premier n'est pas précédé d'une virgule
        foreach ($tabChampsValeurs as $champ => $valeur) {
            if ($numParam != 0) {
                $query.= ", ";
            }
            $query.= $champ . " = ? ";  // ajout d'une clause du type champ = ?
            $tabValeurs[] = $valeur; // mémorisation de la valeur
            $numParam++;
        }
        // Clause de restriction
        $query.= " WHERE IDORGANISATION = ? ";
        $tabValeurs[] = $valeurClePrimaire;
        $queryPrepare = $pdo->prepare($query);
        // Exécution de la requête
        $retour = $queryPrepare->execute($tabValeurs);
        $this->deconnecter();
                
        return $retour;
    }

    /**
     * insert
     * ajouter un enregistrement dans la table 
     * @param type $tabValeurs : tableau indexé des valeurs à intégrer à la requête (sans l'identifiant)
     * @return boolean : succès/échec de l'insertion
     */
    function insert($tabValeurs) {
        $pdo = $this->connecter();
        $query = "INSERT INTO " . $this->table . " VALUES ( null";
        // Pour chaque valeur à ajouter dans l'enregistrement, insérer un ?
        for ($i = 0; $i < count($tabValeurs); $i++) {
            $query.= ",?";
        }
        $query.= " ) ";
        
        $queryPrepare = $pdo->prepare($query);
        $retour = $queryPrepare->execute($tabValeurs);
        $this->deconnecter();
        return $retour;
    }

    /**
     * delete
     * Supprimer un enregistrement de la table
     * @param type $valeurClePrimaire : identifiant de la table
     * @return boolean : succès/échec de la suppression
     */
    function delete($valeurClePrimaire) {
        $pdo = $this->connecter();
        $query = "DELETE FROM " . $this->table;
        $query.= " WHERE " . $this->clePrimaire . ' = ?';
        $queryPrepare = $pdo->prepare($query);
        $retour = $queryPrepare->execute(array($valeurClePrimaire));
        $this->deconnecter();
        return $retour;
    }

    // ACCESSEURS et MUTATEURS
    public function getPdo() {
        return $this->pdo;
    }

    public function setPdo($pdo) {
        $this->pdo = $pdo;
    }

}