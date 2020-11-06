<?php

define("SERVEURBD", "172.18.58.7");
define("LOGIN", "snir");
define("MOTDEPASSE", "snir");
define("NOMDELABASE", "suiviFormulaire");

function connexionBdd() { //Fonction qui va nous connecter a la base
    try {
        $bdd = new PDO('mysql:host=' . SERVEURBD . ';dbname=' . NOMDELABASE, LOGIN, MOTDEPASSE);
    } catch (Exception $ex) { //si erreur on tue le processus et on affiche le message d'érreur
        die('<br/>Pb connexion serveur Bdd : ' . $ex->getMessage());
    }
    return $bdd;
}

try {
    $bdd = connexionBdd();
    $nom_fichier = "eleves" . ".csv";

    header('Content-Type: application/csv-tab-delimited-table');
    header('Content-Disposition:attachment;filename=' . $nom_fichier);

    $sql = "SELECT * FROM `vue_utilisateurs`";

    $stmt = $bdd->query($sql);


    echo "Nom;Prenom;Date de naissance;Telephone;Email;Classe Prebac;Situation actuelle;Précision\n";
    while ($eleve = $stmt->fetchObject()) {



        echo "    {$eleve->nom};";
        echo "    {$eleve->prenom};";
        echo "    {$eleve->dateDeNaissance};";
        echo "    {$eleve->numeroTel};";
        echo "    {$eleve->adresseEmail};";
        echo "    {$eleve->nomFormationsPrebac};";
        echo "    {$eleve->nomFormationsPostbac};";
        echo "    {$eleve->precisionSituation};";

        echo "\n";
    }
} catch (Exception $ex) {
    print "Erreur : " . $ex->getMessage() . "<br/>";
    die();
}
?>
