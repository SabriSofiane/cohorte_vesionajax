function genererListePrebac() {
    $("#formationsPrebac").empty();
    $.getJSON('php/controleur.php',
            {
                'commande': 'getFormationsPrebac',
            }
    )
            .done(function (donnees, stat, xhr) {
                // génération de la liste déroulante des utilisateurs
                $("#formationsPrebac").append($('<option>', {value: -1}).text("Sélectionnez une classe"));
                $.each(donnees, function (index, ligne) {
                    // ligne contient un objet json de la forme
                    // {"idRegion" : "id de la region"},
                    // {"nomRegion" : "nom de la region"}                 
                    $("#formationsPrebac").append($('<option>', {value: ligne.idFormationsPrebac}).text(ligne.nomFormationsPrebac));
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}
function genererListePostbac() {
    $("#formationsPostbac").empty();
    $.getJSON('php/controleur.php',
            {
                'commande': 'getFormationsPostbac',
            }
    )
            .done(function (donnees, stat, xhr) {
                // génération de la liste déroulante des utilisateurs
                $("#formationsPostbac").append($('<option>', {value: -1}).text("Sélectionnez une situation"));
                $.each(donnees, function (index, ligne) {
                    // ligne contient un objet json de la forme
                    // {"idRegion" : "id de la region"},
                    // {"nomRegion" : "nom de la region"}                 
                    $("#formationsPostbac").append($('<option>', {value: ligne.idFormationsPostbac}).text(ligne.nomFormationsPostbac));
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            });
}

function afficherMentions(event)
{
   event.preventDefault(); 
    console.log("mentions");
     $("#zoneCentrale").empty();
    $("#zoneCentrale").load("mentions.html",function(response,status,xhr){
       if (status == "error")
       {
           $("#zoneCentrale").append("<div>"+xhr.statusText+"</div>");
           
       }
    });
}
function afficherFormulaire(event)
{
    event.preventDefault(); 
    console.log("formulaire");
      $("#zoneCentrale").empty();
    $("#zoneCentrale").load("formulaire.html",function(response,status,xhr){
       if (status == "error")
       {
           $("#zoneCentrale").append("<div>"+xhr.statusText+"</div>");
           
       }
       genererListePostbac();
       genererListePrebac();
    });
}
function afficherContact(event)
{
    event.preventDefault(); 
    console.log("contact");
      $("#zoneCentrale").empty();
    $("#zoneCentrale").load("contact.html",function(response,status,xhr){
       if (status == "error")
       {
           $("#zoneCentrale").append("<div>"+xhr.statusText+"</div>");
           
       }
    });
}
function afficherAccueil()
{
     //event.preventDefault(); 
    console.log("contact");
      $("#zoneCentrale").empty();
    $("#zoneCentrale").load("accueil.html",function(response,status,xhr){
       if (status == "error")
       {
           $("#zoneCentrale").append("<div>"+xhr.statusText+"</div>");
           
       }
    });
}

function envoyerDonneesInscription(event)
{
    event.preventDefault();
    $("#action").val("insert");
    var idClasse=$("#formationsPrebac option:selected").val();
    var idSituation=$("#formationsPostbac option:selected").val();
    $("#formationsPrebac").next('p').remove();
    $("#formationsPostbac").next('p').remove();
    if (idClasse==-1)
    {
        $("<p style='display:inline; color:red'>Vous devez choisir une classe</p>").insertAfter("#formationsPrebac");
    }
    if(idSituation==-1)
        {
           $("<p style='display:inline; color:red'>Vous devez choisir une formation</p>").insertAfter("#formationsPostbac");
        }
    else{
        
        
        
        
    
     $.ajax({          
            url: 'php/gestion_cohorte.php',
            data: $("#formulaireInscription").serialize(), 
            type: 'POST',
            dataType: 'json',
            success: // si la requete fonctionne, mise à jour de la couleur de pastille
                    function(donnees,status,xhr) {
                                      $("#zoneCentrale").empty();
                                      $("#zoneCentrale").append("<div>"+donnees+"</div>")
                                      
                    },
            error:
                    function (xhr, status, error) {
                        console.log("param : " + JSON.stringify(xhr));
                        console.log("status : " + status);
                        console.log("error : " + error);

                    }
        });
    }
    
}
$(document).ready(function ()
{
    // generation de la liste deroulante des regions
    
    $(document).on("click","#suivi",afficherFormulaire);
    $(document).on("click","#mentions",afficherMentions);
    $(document).on("click","#contact",afficherContact);
    $(document).on("click","#suiviAccueil",afficherFormulaire);
    $(document).on("click","#contactPdp",afficherContact);
    $(document).on("click","#mentionsPdp",afficherMentions);
    $(document).on("click","#contactPdpAdmin",afficherAccueil,afficherContact);
    $(document).on("click","#mentionsPdpAdmin",afficherAccueil,afficherMentions);
    afficherAccueil();
    $(document).on('submit',"#formulaireInscription",envoyerDonneesInscription);

});
