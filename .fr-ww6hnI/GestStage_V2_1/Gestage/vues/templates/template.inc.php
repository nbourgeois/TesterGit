<!DOCTYPE html >
<html lang="fr">
    <head>
        <meta  content="text/html;charset=UTF-8" />
        <link rel="stylesheet" href="../vues/css/styleLargeurFixe.css" />
        <title><?php echo $this->titreVue; ?></title>
    </head>
    <body>
            <header>
               <?php include("$this->entete"); ?>
            </header>
            <nav>
               <?php include("$this->gauche"); ?>
            </nav>
            <section>
                <?php include("$this->centre");?>
            </section>
            <footer>
                <?php include("$this->pied");?>
            </footer>
    </body>
</html>
