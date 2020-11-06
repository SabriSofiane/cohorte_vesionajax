<?php
require_once '../php/fonction_formulaire.inc.php';
if (isset($_GET['id'])) {
    $bdd = connexionBdd();

    //requête pour prendre les informations d'un élève
    $sql = "SELECT * FROM `utilisateurs` where idUtilisateurs = {$_GET['id']};";

    $stmt = $bdd->query($sql);
    $eleve = $stmt->fetchObject();
} else {
    $eleve = new stdClass();
    $eleve->nom = "";
    $eleve->prenom = "";
    $eleve->dateDeNaissance = "";
    $eleve->classeFrequentee = "";
    $eleve->situationActuelle = "";
    $eleve->precisionSituation = "";
    $eleve->adresseEmail = "";
    $eleve->numeroTel = "";
    $eleve->idUtilisateurs = 0;
    $eleve->created = "";
    $eleve->updated = "";
    
}
?>
<!DOCTYPE html>
<!--
Createur : Sabri Sofiane
Date de création : 13 octobre 2020
Modified   : 6 nov. 2020, 10:41:39
Description : Le formulaire auquel l'utilisateur va remplir pour effectuer son suivi de cohorte
Powered with Bootstrap
-->
<html>
    <head>
        <title>Formulaire de Suivi - Lycée Gabriel Touchard-Washington</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="../styleFormulaire.css" rel="stylesheet" type="text/css"/>
        <link href="../styleAccueil.css" rel="stylesheet" type="text/css"/>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="../scripts/jquery-confirm.min.js"></script>
        <script>
            $(function () {
                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    endDate: '+0d',
                    autoclose: true
                });
            });
        </script>
    </head>
    <body>

        <a href="index.php" class="logo" >
            <img src="../images/LYCEE-TW-RVB-BLEU@2x-ouqqzhaifqs0ecueqajd2l306gb31pbjc3bpoxcfrw.png" alt="Logo" class="logo" style="padding-left: 12px;padding-top: 65px;" />
        </a>
        <div class="container-fluid">
            <h1 class="titreFormulaire"   >Suivi d'inscription</h1>
        </div>
        <div class="container-fluid "> 
            <a href="../index.php">
                <img  style="padding-bottom: 12px;" />
            </a>



            
            <?php
            require_once '../menu.php';
            ?>
        </div>
        <div class="boite">
            <div class="boite2">
                <form action="gestion_cohorte.php" method="post">
                    <div class="form-group">
                        <?php
                        if (!isset($_GET['id'])) {
                            echo '<input type="hidden" name="action" value="insert"> ';
                        } else {
                            echo '<input type="hidden" name="action" value="update"> ';
                            echo "<input type='hidden' name='idUtilisateurs' value='{$eleve->idUtilisateurs}'> ";
                        }
                        ?>
                        <div class="form-row">
                            <label for="created" class="col-sm-2 col-form-label">id:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->idUtilisateurs; ?>" class="form-control" name="created" readonly>
                            </div>

                        </div>
                        <br/>

                        <div class="form-row">
                            <label for="created" class="col-sm-2 col-form-label">Date de création:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->created; ?>" class="form-control" name="created" readonly>
                            </div>

                        </div>
                        <br/>
                        <div class="form-row">
                            <label for="created" class="col-sm-2 col-form-label">Date de modification:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->updated; ?>" class="form-control" name="created" readonly>
                            </div>

                        </div>
                        <br/>

                        <div class="form-row">
                            <label for="prenom" class="col-sm-2 col-form-label">Donnez votre prénom*:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->prenom; ?>" class="form-control" name="prenom" placeholder="Prénom" id="prenom" required="required" pattern="^[a-zA-Z\-çïéêëîÏÎËÊÉÈÇœ' ]*$">
                            </div>

                        </div>

                        <br/>
                        <div class="form-row">
                            <label for="nom" class="col-sm-2 col-form-label">Donnez votre nom*:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->nom; ?>" class="form-control" placeholder="Nom" name="nom" id="nom" required="required" pattern="^[a-zA-Z\-çïéêëîÏÎËÊÉÈÇœ' ]*$">
                            </div>
                        </div>

                        <br/>
                        <div class="form-row">
                            <label for="dateDeNaissance" class="col-sm-2 col-form-label">Donnez votre date de naissance*:</label>
                            <div class="col-sm-10">
                                <input type="date" value="<?php echo $eleve->dateDeNaissance; ?>" class="form-control" name="dateDeNaissance" id="dateDeNaissance" required="required" data-date-end-date="0d">
                            </div>
                        </div>
                        <br/>
                        <div class="form-row">
                            <label for="classeFrequentee" class="col-sm-2 col-form-label" >Classe fréquentée lors du diplôme*:</label>
                            <div class="col-sm-10">
                                <?php
                                genererListeFormationsPrebac($eleve->classeFrequentee);
                                ?>


                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <label for="situationActuelle" class="col-sm-2 col-form-label">Selectionnez votre situation actuelle*:</label>
                            <div class="col-sm-10">
                                <?php
                                genererListeFormationsPostbac($eleve->situationActuelle);
                                ?>
                            </div>


                        </div>
                        <div class="form-row">
                            <label for="nom" class="col-sm-2 col-form-label">Veuillez préciser*:</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $eleve->precisionSituation; ?>" class="form-control" placeholder="Préciser" name="precisionSituation" id="precisionSituation" required="required" >
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="form-row">
                            <label for="numeroTel" class="col-sm-2 col-form-label">Numéro de téléphone:</label>
                            <div class="col-sm-10">
                                <input type="tel" value="<?php echo $eleve->numeroTel; ?>" class="form-control" placeholder="" id="numeroTel" name="numeroTel" pattern="[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}.[0-9]{2}">
                                <small>Format : 01.02.03.04.05</small>
                            </div>
                            <br/>
                        </div>
                        <br>
                        <div class="form-row">
                            <label for="addressEmail" class="col-sm-2 col-form-label">Adresse mail valable*:</label>
                            <div class="col-sm-10">
                                <input type="email" value="<?php echo $eleve->adresseEmail; ?>" class="form-control" placeholder="un@exemple.com" id="adresseEmail" name="adresseEmail" required="required">
                            </div>
                            <br/>

                        </div>
                        <br/>
                        
                        <small>* :champ obligatoire</small>
                        <br/>
                        <br/>

                        <div class="form-row " >
                            <button type="submit" class="btn btn-primary  ">Envoyer</button>
                        </div>
                        <br/>
                        <br/>
                        
                    </div>
                </form>
            </div>
        </div>
        <?php require_once '../footer.php'; ?>





        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </body>
</html>
