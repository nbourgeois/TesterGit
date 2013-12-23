<?php

class C_Accueil extends Controleur {

    /**
     * controleur= accueil & action= index
     * Afficher la page d'accueil
     */
    function index() {
        $this->vue->titreVue = "GestStage : Accueil";
        $this->vue->entete = "../vues/templates/entete.inc.php";

        $this->vue->gauche = "../vues/templates/gauche.inc.php";

        $this->vue->pied = "../vues/templates/pied.inc.php";
        $this->vue->loginAuthentification = MaSession::get('login');

        $this->vue->centre = "../vues/accueil/templates/centre.inc.php";
        $this->vue->afficher();
    }

    /**
     * controleur= accueil & action= seConnecter
     * Afficher le formulaire d'authentification au centre
     */
    function seConnecter() {
        $this->vue->titreVue = "GestStage : Accueil";
        $this->vue->entete = "../vues/templates/entete.inc.php";
       
        $this->vue->gauche = "../vues/templates/gauche.inc.php";
        
        $this->vue->pied = "../vues/templates/pied.inc.php";
        // Centre : formulaire de connexion
        $this->vue->centre = "../vues/accueil/templates/centre.seConnecter.inc.php";

        $this->vue->afficher();
    }

    /**
     * controleur= accueil & action= authentifier
     * Vérifier les données d'authentification :
     *  - si c'est correct, démarrer une nouvelle session et afficher la page d'accueil
     *  - sinon, réafficher l'écran d'authentification
     */
    function authentifier() {
        $this->vue->titreVue = "GestStage : Accueil";
        $this->vue->entete = "../vues/templates/entete.inc.php";
        
        // préparer la liste des catégories de produits pour le menu de gauche
        $this->vue->gauche = "../vues/templates/gauche.inc.php";
        $this->vue->pied = "../vues/templates/pied.inc.php";
        $this->vue->centre = "../vues/accueil/templates/centre.inc.php";
 

        //------------------------------------------------------------------------
        // VUE CENTRALE
        //------------------------------------------------------------------------
        $lesUsers = new M_Utilisateurs();
        // Vérifier login et mot de passe saisis dans la formulaire d'authentification
        if (isset($_POST['login']) && isset($_POST['mdp'])) {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];
            $unUser=$lesUsers->verifierLogin($login, $mdp);
            if ($unUser) {
                // Si le login et le mot de passe sont valides, ouvrir une nouvelle session
                MaSession::nouvelle(array('login' => $login, 'role' => $unUser["IDROLE"])); // service minimum
                $this->vue->message = "Authentification r&eacute;ussie";
                $this->vue->centre = "../vues/accueil/templates/centre.inc.php";
            } else {
                $this->vue->message = "ECHEC d'identification : login ou mot de passe inconnus ";
                $this->vue->centre = "../vues/accueil/templates/centre.seConnecter.inc.php";
            }
        } else {
            $this->vue->message = "Attention : le login ou le mot de passe ne sont pas renseign&eacute;s";
            $this->vue->centre = "../vues/accueil/templates/centre.seConnecter.inc.php";
        }
        //------------------------------------------------------------------------

        $this->vue->loginAuthentification = MaSession::get('login');
        $this->vue->afficher();
        
        
//        $this->vue->roleAuthentification = get('idRole');
    }

    /**
     * controleur= accueil & action= seDeconnecter
     * Afficher fermer la session en cours et afficher la page d'accueil
     */
    function seDeconnecter() {
        MaSession::fermer();
        header("Location:  index.php");
    }

}