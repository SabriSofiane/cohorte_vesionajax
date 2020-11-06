<?php

require_once './fonction_formulaire.inc.php';
$eleve = new stdClass();

if ($_POST["action"] == "insert") {//insert
    $eleve->prenom = filter_input(INPUT_POST, 'prenom');
    $eleve->nom = filter_input(INPUT_POST, 'nom');
    $eleve->dateDeNaissance = filter_input(INPUT_POST, 'dateDeNaissance');
    $eleve->classeFrequentee = filter_input(INPUT_POST, 'classeFrequentee');
    $eleve->situationActuelle = filter_input(INPUT_POST, 'situationActuelle');
    $eleve->precisionSituation = filter_input(INPUT_POST, 'precisionSituation');
    $eleve->numeroTel = filter_input(INPUT_POST, 'numeroTel');
    $eleve->adresseEmail = filter_input(INPUT_POST, 'adresseEmail');
    $eleve->rgpd = filter_input(INPUT_POST, 'rgpd');
    
    $retour = ajouterUtilisateur($eleve);
    if ($retour) {
        header('Content-Type: application/json');

        echo json_encode("Votre suivi à été pris en compte.");
    } else {
        header('Content-Type: application/json');

        echo json_encode("Erreur dans l'ajout de l'utilisateur");
    }
}
if ($_POST["action"] == "update") { //update
    $eleve->prenom = filter_input(INPUT_POST, 'prenom');
    $eleve->nom = filter_input(INPUT_POST, 'nom');
    $eleve->dateDeNaissance = filter_input(INPUT_POST, 'dateDeNaissance');
    $eleve->classeFrequentee = filter_input(INPUT_POST, 'classeFrequentee');
    $eleve->situationActuelle = filter_input(INPUT_POST, 'situationActuelle');
    $eleve->precisionSituation = filter_input(INPUT_POST, 'precisionSituation');
    $eleve->numeroTel = filter_input(INPUT_POST, 'numeroTel');
    $eleve->adresseEmail = filter_input(INPUT_POST, 'adresseEmail');
    $eleve->idUtilisateurs = filter_input(INPUT_POST, 'idUtilisateurs');
    $eleve->rgpd = 1;
    $retour = modifierUtilisateur($eleve);
    if ($retour) {


        header("Location: vue_eleves.php?conf=OK");
    } else {

        header("Location: vue_eleves.php?conf=NOK");
    }
}
?>
