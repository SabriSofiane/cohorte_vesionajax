<!--
Createur : Sabri Sofiane
Date de création : 13 octobre 2020
Modified   : 6 nov. 2020, 10:41:39
Description : Page de confirmation après envoi du formuliare
Powered with Bootstrap
-->
<html>
    <head>
        <title>Formulaire de Suivi - Lycée Gabriel Touchard-Washington</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="styleFormulaire.css" rel="stylesheet" type="text/css"/>
        <link href="styleAccueil.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        <a href="index.php" class="logo" >
            <img src="images/LYCEE-TW-RVB-BLEU@2x-ouqqzhaifqs0ecueqajd2l306gb31pbjc3bpoxcfrw.png" alt="Logo" class="logo" style="padding-left: 12px;padding-top: 12px;" />
        </a>
        <div class="container-fluid">
            <h1 class="titre" style="right: 600px;"  >Suivi d'inscription</h1>
        </div>
        <div class="container-fluid "> 
            



            <!--        <div class="alert-success">Dropdown hover</div>-->
            <?php
            require_once './menu.php';
            ?>
        </div>
        <div class="container-fluid description">
            <?php
            // affichage du message de confirmation lors de l'inscription
            if ($_GET["conf"] === "NOK") {
                echo "Erreur lors de l'inscription.";
            } else {
                echo "Votre inscription a bien été pris en compte.";
            }
            ?>
            <br>
            <br>
<!--            <a class="btn btn-primary" href="#" role="button">Modifier</a>-->
            <a class="btn btn-primary bouton" href="index.php" role="button">Revenir à l'accueil</a>
        </div>
        <?php require_once 'footer.php';?>
        
    </body>
</html>