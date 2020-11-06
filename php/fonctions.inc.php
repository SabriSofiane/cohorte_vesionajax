<?php

define("SERVEURBD", "172.18.58.7");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "suiviFormulaire");

/**
 * @brief crée la connexion avec la base de donnée et retourne l'objet PDO pour manipuler la base
 * @return \PDO
 */
function connexionBdd() {
    try {
        $pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE, LOGIN, MOTDEPASSE, $pdoOptions);
        $bdd->exec("set names utf8");
        return $bdd;
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

/**
 * @brief retourne l'ensemble des régions sous forme de tableau json
 */
function getListePrebac() {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->query("SELECT * FROM `formationsPrebac` ORDER BY `formationsPrebac`.`nomFormationsPrebac` ASC ") or die(print_r($requete->errorInfo()));

        $tabFormationsPrebac = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : idRegion, nomRegion
            array_push($tabFormationsPrebac, array('idFormationsPrebac' => $tab['idFormationsPrebac'], 'nomFormationsPrebac' => $tab['nomFormationsPrebac']));
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabFormationsPrebac);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}
function getListePostbac() {
    try {
        // connexion BD
        $bdd = connexionBdd();

        $requete = $bdd->query("SELECT * FROM `formationsPostbac`") or die(print_r($requete->errorInfo()));

        $tabFormationsPostbac = array();

        while ($tab = $requete->fetch()) {
            // ajout d'une case dans le tableau
            // la case est elle-même un tableau contenant 2 champs : idRegion, nomRegion
            array_push($tabFormationsPostbac, array('idFormationsPostbac' => $tab['idFormationsPostbac'], 'nomFormationsPostbac' => $tab['nomFormationsPostbac']));
        }

        $requete->closeCursor();
        //on previent qu'on repond en json
        header('Content-Type: application/json');
        // envoyer les données au format json
        echo json_encode($tabFormationsPostbac);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

