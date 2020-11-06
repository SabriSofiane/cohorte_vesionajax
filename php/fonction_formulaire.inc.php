<?php

//Coordonées de la Base de donnée
define("SERVEURBD", "172.18.58.7");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "suiviFormulaire");

// Définition de l'utilisateur smtp
define("SMTPUSER", "philippe.simier.pro@gmail.com");
define("SMTPPWD", "Jelbroet2020!");

function connexionBdd() { //Fonction qui va nous connecter a la base
    try {
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE, LOGIN, MOTDEPASSE);
    } catch (Exception $ex) { //si erreur on tue le processus et on affiche le message d'érreur
        die('<br/>Pb connexion serveur Bdd : ' . $ex->getMessage());
    }
    return $bdd;
}

function genererListeFormationsPrebac($idFormationsPrebac) {
//fonction qui va génerer la liste déroulante des formations prébac dans le formulaire
    try {
        $bdd = connexionBdd();
        //requete sql permetant d'afficher les formations
        $requete = $bdd->query("SELECT * FROM `formationsPrebac` ORDER BY `formationsPrebac`.`nomFormationsPrebac` ASC ")
                or die(print_r($requete->errorInfo()));
        //la liste déroulante est ici avec les options de la base
        echo '<select name="classeFrequentee">';
        while ($ligne = $requete->fetch()) {
            echo "<option value='{$ligne["idFormationsPrebac"]}' ";
            if ($ligne['idFormationsPrebac'] == $idFormationsPrebac) {
                echo ' selected>';
            } else {
                echo ">";
            }

            echo "{$ligne['nomFormationsPrebac']}";
            echo "</option>\n";
        }
        echo '</select>';
        //on termine la requete
        $requete->closeCursor();
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function genererListeFormationsPostbac($idFormationsPostbac) {
//fonction qui va génerer la liste déroulante des formations postbac dans le formulaire
    try {
        $bdd = connexionBdd();
        //requete sql permetant d'afficher les formations
        $requete = $bdd->query("SELECT * FROM `formationsPostbac`")
                or die(print_r($requete->errorInfo()));
        //la liste déroulante est ici avec les options de la base
        echo '<select name="situationActuelle">';
        while ($ligne = $requete->fetch()) {
            echo "<option value='{$ligne["idFormationsPostbac"]}' ";
            if ($ligne['idFormationsPostbac'] == $idFormationsPostbac) {
                echo ' selected>';
            } else {
                echo ">";
            }

            echo "{$ligne['nomFormationsPostbac']}";
            echo "</option>\n";
        }
        echo '</select>';
        //on termine la requete
        $requete->closeCursor();
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function ajouterUtilisateur($eleve) {
//Fonction qui ajoute un utilisateur grace au formulaire
    try {
        
        $bdd = connexionBdd();

        if ($eleve->rgpd == "on") {
            $eleve->rgpd = 1;
        }
        $requete = $bdd->prepare("insert into utilisateurs"
                . "(nom,prenom,dateDeNaissance,numeroTel,adresseEmail,situationActuelle,precisionSituation,classeFrequentee,rgpd)"
                . "values (:nom,:prenom,:dateDeNaissance,:numeroTel,:adresseEmail,:situationActuelle,:precisionSituation,:classeFrequentee,:rgpd);");
        $requete->bindParam(":nom", $eleve->nom);
        $requete->bindParam(":prenom", $eleve->prenom);
        $requete->bindParam(":dateDeNaissance", $eleve->dateDeNaissance);
        $requete->bindParam(":numeroTel", $eleve->numeroTel);
        $requete->bindParam(":adresseEmail", $eleve->adresseEmail);
        $requete->bindParam(":situationActuelle", $eleve->situationActuelle);
        $requete->bindParam(":precisionSituation", $eleve->precisionSituation);
        $requete->bindParam(":classeFrequentee", $eleve->classeFrequentee);
        $requete->bindParam(":rgpd", $eleve->rgpd);

        $retour = $requete->execute();
        return $retour;


        //on termine la requete
        $requete->closeCursor();
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function modifierUtilisateur($eleve) {
    //fonction qui modifie un élève par une requête
    try {
        $bdd = connexionBdd();


        $requete = $bdd->prepare("UPDATE `utilisateurs` SET "
                . "`nom` = :nom, "
                . "`prenom` = :prenom, "
                . "`dateDeNaissance` = :dateDeNaissance, "
                . "`numeroTel` = :numeroTel, "
                . "`adresseEmail` = :adresseEmail, "
                . "`situationActuelle` = :situationActuelle, "
                . "`precisionSituation` = :precisionSituation, "
                . "`classeFrequentee` = :classeFrequentee, "
                . "`updated` = now() "
                . "WHERE `utilisateurs`.`idUtilisateurs` = :idUtilisateurs;");
        $requete->bindParam(":nom", $eleve->nom);
        $requete->bindParam(":prenom", $eleve->prenom);
        $requete->bindParam(":dateDeNaissance", $eleve->dateDeNaissance);
        $requete->bindParam(":numeroTel", $eleve->numeroTel);
        $requete->bindParam(":adresseEmail", $eleve->adresseEmail);
        $requete->bindParam(":situationActuelle", $eleve->situationActuelle);
        $requete->bindParam(":precisionSituation", $eleve->precisionSituation);
        $requete->bindParam(":classeFrequentee", $eleve->classeFrequentee);
        $requete->bindParam("idUtilisateurs", $eleve->idUtilisateurs);

        $retour = $requete->execute();

        return $retour;


        //on termine la requete
        $requete->closeCursor();
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function afficherVueUtilisateurs() {
// fonction qui afficher la vue de notre base de donnée dans la page vue_eleves
    try {
        $bdd = connexionBdd();


        $sql = "SELECT * FROM `vue_utilisateurs`";

        $stmt = $bdd->query($sql);

        while ($eleve = $stmt->fetchObject()) {
            echo "<tr>\n";
            echo "    <td><input class='selection' type='checkbox' name='table_array[$eleve->idUtilisateurs]' value='$eleve->idUtilisateurs' ></td>\n";

            echo "    <td>{$eleve->nom}</td>\n";
            echo "    <td>{$eleve->prenom}</td>\n";
            echo "    <td>{$eleve->dateDeNaissance}</td>\n";
            echo "    <td>{$eleve->numeroTel}</td>\n";
            echo "    <td>{$eleve->adresseEmail}</td>\n";
            echo "    <td>{$eleve->nomFormationsPrebac}</td>\n";
            echo "    <td>{$eleve->nomFormationsPostbac}</td>\n";
            echo "    <td>{$eleve->precisionSituation}</td>\n";

            echo "</tr>\n";
        }
    } catch (Exception $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
