<?php
require_once '../php/fonction_formulaire.inc.php';

//connexion base de données
$bdd = connexionBdd();
// Si le formulaire a été soumis
if (isset($_POST['btn_supprimer'])) {
    // Si un élément a été sélectionné création de la liste des id à supprimer
    if (count($_POST['table_array']) > 0) {
        $Clef = $_POST['table_array'];
        $supp = "(";
        foreach ($Clef as $selectValue) {
            if ($supp != "(") {
                $supp .= ",";
            }
            $supp .= $selectValue;
        }
        $supp .= ")";

        try {
            //requête pour suppression des utilisateurs
            $sql = "DELETE FROM `utilisateurs` WHERE `idUtilisateurs` IN " . $supp;
            $bdd->exec($sql);
        } catch (Exception $ex) {
            die('Erreur : ' . $ex->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Vue des élèves</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="../styleFormulaire.css" rel="stylesheet" type="text/css"/>
        <link href="../styleAccueil.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../datatables.min.css"/>
        <link rel="stylesheet" href="../dataTables.css" />
        <link rel="stylesheet" href="../jquery-confirm.min.css" />
        <link rel="stylesheet" href="../bootstrap.min.css">


        <script src="../scripts/bootstrap.min.js"></script> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="../scripts/jquery-confirm.min.js"></script>
        <script src="//cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
        <script >
            $(document).ready(function () {
                //affichage structure datatable  
                let options = {
                    dom: 'ptlf',
                    pagingType: "simple_numbers",
                    lengthMenu: [10, 30, 60, 120, 600],
                    pageLength: 10,
                    order: [[1, 'desc']],
                    columns: [{orderable: false}, {type: "text"}, {type: "text"}, {type: "text"}, {type: "text"}, {type: "text"}, {type: "text"}, {type: "text"},{type: "text"}],
                    "language": {
                        "url": "../scripts/dataTable.French.json"
                    }

                };
                $('#tableau').DataTable(options);


                function cocherTout(etat)
                {
                    var cases = document.getElementsByTagName('input');   // on recupere tous les INPUT
                    for (var i = 1; i < cases.length; i++)     // on les parcours
                        if (cases[i].type == 'checkbox')     // si on a une checkbox...
                        {
                            cases[i].checked = etat;
                        }
                }

                
                $("#all").click(function () {
                    cocherTout(this.checked);
                });


                $("#btn_supp").click(function () {
                    console.log("Bouton Supprimer cliqué");


                    nbCaseCochees = $('input:checked').length - $('#all:checked').length;
                    console.log(nbCaseCochees);
                    if (nbCaseCochees > 0) {
                        //Popup qui va confirmer la suppression
                        $.confirm({
                            theme: 'bootstrap',
                            title: 'Confirmation!',
                            content: 'Confirmez-vous la suppression de ' + nbCaseCochees + ' objet(s) ?',
                            buttons: {
                                confirm: {
                                    text: 'Confirmer', // text for button
                                    btnClass: 'btn-blue', // class for the button
                                    action: function () {
                                        $("#supprimer").submit(); // soumission du formulaire
                                    }
                                },
                                cancel: {
                                    text: 'Annuler', // text for button
                                    action: function () {}
                                }
                            }
                        });

                    } else {
                        $.alert({
                            theme: 'bootstrap',
                            title: 'Alert!',
                            content: "Vous n'avez sélectionné aucun objet !"
                        });

                    }
                });

                $("#btn_mod").click(function () {
                    console.log("Bouton modifier cliqué");

                    // Ce tableau va stocker les valeurs des checkbox cochées
                    var checkbox_val = [];

                    // Parcours de toutes les checkbox checkées"
                    $('.selection:checked').each(function () {
                        checkbox_val.push($(this).val());
                    });

                    if (checkbox_val.length == 0) {
                        $.alert({
                            theme: 'bootstrap',
                            title: 'Alert!',
                            content: "Vous n'avez sélectionné aucun objet !"
                        });
                    }
                    //On ne peut pas modifier plusieurs personnes en même temps
                    if (checkbox_val.length > 1) {
                        $.alert({
                            theme: 'bootstrap',
                            title: 'Alert!',
                            content: "Vous avez sélectionné plusieurs objets !"
                        });
                    }
                    if (checkbox_val.length == 1) {
                        //On va prendre l'id de l'utilisateur et le mêttre dans le formulaire en modification
                        console.log("./formulaire.php?id" + checkbox_val[0]);
                        window.location = './formulaire.php?id=' + checkbox_val[0];
                    }
                });



            });



        </script>
    </head>
    <body>
       
        <div class="container" style="padding-top: 50px; max-width: 1500px;">
            <div class="row popin card">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div  class="card-header" style=""><h4>Vue des élèves</h4></div>
                    <div class="table-responsive">
                        <!--Formulaire supprimer-->
                        <form method="post" id="supprimer">
                            <table id="tableau" class="table display table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th><input type='checkbox' name='all' value='all' id='all' ></th>

                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date de naissance</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Classe prebac</th>
                                        <th>Situation actuelle</th>
                                        <th>Précision situation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php afficherVueUtilisateurs(); ?>
                                </tbody>
                            </table>


                            <a href="./exportcsv.php" type="button" class="btn btn-secondary">Exporter en .csv</a>
                            <a href="../formulaire.html" type="button" class="btn btn-secondary">Ajouter</a>
                            <input id="btn_mod" name="btn_modifier" value="Modifier" class="btn btn-secondary" readonly size="9">
                            <input id="btn_supp" name="btn_supprimer" value="Supprimer" class="btn btn-danger" readonly size="9">



                        </form>
                        <p></br></br></br></p>	
                    </div>
                </div>
            </div>
            
    </body>
</html>
