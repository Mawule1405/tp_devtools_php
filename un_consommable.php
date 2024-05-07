<?php
/*Ce fichier me permet d'afficher, de modifier et de supprimer un consommable  */
include "fonctions.php";

$enregistrerModification = "";
$annulerModification="";
$annulerSuppression = "";
$confirmerSuppresion ="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump(($_POST));
    if (isset($_POST['action']) && $_POST['action'] === 'enregistrer') {
        var_dump(($_POST));
        // Les données sont envoyées pour être enregistrées
        $enregistrerModification = "";
        $_POST["enregistre"] = "";
        $idConsommable = $_POST['idConsommable'];
        $nomConsommable = $_POST['nomConsommable'];
        $qteStock = $_POST['qteStock'];
        $qteSeuil = $_POST['qteSeuil'];
        $prixUnitaire = $_POST['prixUnitaire'];
        var_dump(($_POST));
        // Traiter l'image si nécessaire
        var_dump(($prixUnitaire));
        // Faites ce que vous devez faire avec les données ici
    } elseif (isset($_POST['action']) && $_POST['action'] === 'annuler') {
        // Le bouton "Annuler" a été pressé
        // Traitement pour annuler
        $annulerModification = "";
        var_dump("AU REVOIR");
    }elseif (isset($_POST['action']) && $_POST['action'] === 'confirmerSuppression') {
        // Le bouton "Confirmer" de la fenêtre modale de suppression a été pressé
        var_dump(("suppression confirmer"));
        // Effectuer le traitement de suppression
    } elseif (isset($_POST['action']) && $_POST['action'] === 'annulerSuppression') {
        // Le bouton "Annuler" de la fenêtre modale de suppression a été pressé
        // Effectuer le traitement nécessaire
        var_dump(("suppression annuler"));
    }
}



function buildConsommable($consommable){
    /*La fonction permet de gérer tout ce qui concerne un consommable 
    @param: Consommable */
    if($consommable['image']){
        $image = localPathToUrl($consommable['image']);
    }else{
        $image = localPathToUrl("C:\wamp64\www\DEV\image\image_consommable\defaut.jpeg");
    }

    echo <<<TAB
    <table>
        <tr>
            <td rowspan="5"> <img src="{$image}" alt="{$consommable['nom_cons']}" width=150 height=150 >  </td>
            <td colspan="2"> ID Consommable: {$consommable['id_cons']}  </td>
        </tr>

        <tr>
            <td> Nom:   </td>
            <td> {$consommable['nom_cons']} </td>
            <td> <button class="action-button" onclick="openEditModal({$consommable['id_cons']}, '{$consommable['nom_cons']}', {$consommable['qtestock_cons']}, {$consommable['qteseuil_cons']}, {$consommable['prix_unitaire_cons']})"> Modifier </button>   </td>
        </tr>

        <tr>
            <td> Quantité en stock :  </td>
            <td> {$consommable['qtestock_cons']} </td>  
            <!-- Ajoutez un identifiant unique à chaque bouton "Supprimer" -->
            <td> <button class="action-button" onclick="confirmationSuppression({$consommable['id_cons']})">Supprimer</button> </td>

        </tr>

        <tr>
            <td> Quantité en seuil :  </td>
            <td> {$consommable['qteseuil_cons']} </td>
            <td> 
                <button class="action-button" onclick="redirectApprovisionnement()"> Approvisionner </button>   
            </td> 

        </tr>

        <tr>
            <td> Prix unitaire :  </td>
            <td> {$consommable['prix_unitaire_cons']} FCFA</td>
            <td> 
                <button class="action-button" onclick="openAttributionModal()"> Attribuer </button>   
            </td>
        </tr>
    </table>
TAB;
}

  
buildConsommable((getOneConsommable(1)[0]));
buildConsommable((getOneConsommable(2)[0]));
?>

<!-- Définition de la fenêtre modale -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>Modifier les données du consommable</h2>
        <form id="editForm"  method="post" >
            <input type="hidden" id="idConsommable" name="idConsommable">
            <label for="nomConsommable">Nom du consommable:</label>
            <input type="text" id="nomConsommable" name="nomConsommable"><br>
            <label for="qteStock">Quantité en stock:</label>
            <input type="number" id="qteStock" name="qteStock"><br>
            <label for="qteSeuil">Quantité seuil:</label>
            <input type="number" id="qteSeuil" name="qteSeuil"><br>
            <label for="prixUnitaire">Prix unitaire (FCFA):</label>
            <input type="number" id="prixUnitaire" name="prixUnitaire"><br>
            <input type="file" id="image" name="image"> <br>
            <button type="submit" onclick= "closeModal()" name="action"  value="<?php $annulerModification ?>" id="annuler-btn">Annuler</button>
            <button type="submit" onclick="saveChanges()" name="action"  value="<?php $enregistrerModification ?>" id= "enregistrer-btn">Enregistrer</button>
        </form>
    </div>
</div>


<!-- Fenêtre modale de confirmation -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <h2>Confirmation </h2>
        <p>Êtes-vous sûr de vouloir supprimer ce consommable ?</p>
        <form class="modal-buttons" method="post">
            <button id="confirmerSuppression" name="action" value="<?php $confirmerSuppresion?>">Confirmer</button>
            <button id="annulerSuppression" name="action" value="<?php $annulerSuppression?>">Annuler</button>
        </form>
    </div>
</div>


<!-- Fenêtre modale d'attribution -->
<div id="attributionModal" class="modal">
    <div class="modal-content">
        <h2>Attribuer le consommable</h2>
        <form id="attributionForm" onsubmit="confirmAttribution()">
            <label for="employee">Employé :</label>
            <select id="employee" name="employee">
                <!-- Options pour les employés -->
                <option value="employee1">Employé 1</option>
                <option value="employee2">Employé 2</option>
                <!-- Ajoutez d'autres options selon vos besoins -->
            </select><br>
            <label for="quantity">Quantité :</label>
            <input type="number" id="quantity" name="quantity"><br>
            <button type="submit">Confirmer</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(idConsommable, nomConsommable, qteStock, qteSeuil, prixUnitaire) {
    // Récupérer la fenêtre modale et les champs du formulaire
    var modal = document.getElementById("editModal");
    var idInput = document.getElementById("idConsommable");
    var nomInput = document.getElementById("nomConsommable");
    var qteStockInput = document.getElementById("qteStock");
    var qteSeuilInput = document.getElementById("qteSeuil");
    var prixUnitaireInput = document.getElementById("prixUnitaire");
    var imageInput =document.getElementById('image');

    // Remplir les champs du formulaire avec les données du consommable
    idInput.value = idConsommable;
    nomInput.value = nomConsommable;
    qteStockInput.value = qteStock;
    qteSeuilInput.value = qteSeuil;
    prixUnitaireInput.value = prixUnitaire;
    

    // Afficher la fenêtre modale
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("editModal");
    modal.style.display = "none"; // Cacher la fenêtre modale
    //Changer la valeur du bouton
    var boutonEnregistrer = document.getElementById("annuler-btn");
    boutonEnregistrer.value = "annuler";
  }


  function saveChanges() {

    var idConsommable = document.getElementById("idConsommable").value;
    var nomConsommable = document.getElementById("nomConsommable").value;
    var qteStock = document.getElementById("qteStock").value;
    var qteSeuil = document.getElementById("qteSeuil").value;
    var prixUnitaire = document.getElementById("prixUnitaire").value;
    var image = document.getElementById("image").files[0]; // Récupérer le fichier image
    var boutonEnregistrer = document.getElementById("enregistrer-btn");
    boutonEnregistrer.value = "enregistrer";

    // Créer un objet FormData pour envoyer les données du formulaire
    var formData = new FormData();
    formData.append('idConsommable', idConsommable);
    formData.append('nomConsommable', nomConsommable);
    formData.append('qteStock', qteStock);
    formData.append('qteSeuil', qteSeuil);
    formData.append('prixUnitaire', prixUnitaire);
    formData.append('image', image); // Ajouter l'image au FormData

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'un_consommable.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Gérer la réponse du serveur si nécessaire
            // Par exemple, actualiser la page ou afficher un message de confirmation
            
        } else {
            console.error('Erreur lors de l\'enregistrement des modifications.');
        }
    };
    xhr.send(formData); // Envoyer les données du formulaire au serveur via AJAX
    closeModal();
    location.reload(true);
}

function confirmationSuppression(idConsommable) {
    // Récupérer la fenêtre modale de confirmation
    var modal = document.getElementById("confirmationModal");
    
    // Afficher la fenêtre modale
    modal.style.display = "block";

    // Gérer la suppression lors de la confirmation
    document.getElementById("confirmerSuppression").addEventListener("click", function() {
        var boutonConfirmer = document.getElementById("confirmerSuppression");
        boutonConfirmer.value = "confirmerSuppression";
        
        // Fermer la fenêtre modale
        modal.style.display = "none";

        // Créer un objet FormData pour envoyer les données du formulaire
        var formData = new FormData();
        formData.append('idConsommable', idConsommable);

        // Envoyer une requête AJAX pour supprimer le consommable côté serveur
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'un_consommable.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Gérer la réponse du serveur si nécessaire
                console.log('Consommable supprimé avec succès');
                // Rafraîchir la page ou effectuer d'autres actions
            } else {
                console.error('Erreur lors de la suppression du consommable');
            }
        };
        xhr.send(formData); // Envoyer les données du formulaire au serveur via AJAX
    });

    // Annuler la suppression si l'utilisateur clique sur "Annuler"
    document.getElementById("annulerSuppression").addEventListener("click", function() {
        var boutonAnnulation = document.getElementById("annulerSuppression");
        boutonAnnulation.value = "AnnuerSuppression";
        modal.style.display = "none"; // Fermer la fenêtre modale
        console.log("Suppression annulée");
    });
}


function redirectApprovisionnement() {
    // Rediriger vers la page approvisionnement.php
    window.location.href = "approvisionnement.php";
}


// Fonction pour afficher la fenêtre modale d'attribution
function openAttributionModal() {
    var modal = document.getElementById("attributionModal");
    modal.style.display = "block";
}

// Fonction pour traiter la confirmation de l'attribution
function confirmAttribution() {
    // Récupérer les valeurs des champs
    var employee = document.getElementById("employee").value;
    var quantity = document.getElementById("quantity").value;

    // Effectuer les actions nécessaires, par exemple :
    console.log("Employé sélectionné :", employee);
    console.log("Quantité attribuée :", quantity);

    // Fermer la fenêtre modale
    var modal = document.getElementById("attributionModal");
    modal.style.display = "none";

    // Empêcher le formulaire de se soumettre normalement
    event.preventDefault();
}

</script>




<style>
    .modal {
        display: none; /* Masquer la fenêtre modale par défaut */
        position: fixed; /* Position fixe pour rester au-dessus du contenu de la page */
        z-index: 1; /* Plus haut niveau d'empilement pour s'assurer qu'il est visible */
        left: 25%;
        top: 0;
        width: 50%; /* Pleine largeur */
        height: 150%; /* Pleine hauteur */
        overflow: auto; /* Activer le défilement si nécessaire */
        background-color: rgb(0,0,0); /* Fond semi-transparent */
        background-color: rgba(0,0,0,0); /* Fond semi-transparent avec transparence */
    }

    /* Contenu de la fenêtre modale */
    .modal-content {
        background-color: #fefefe; /* Fond de la fenêtre modale */
        margin: 15% auto; /* Marge de 15% vers le haut et vers le bas, centré horizontalement */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Largeur de la fenêtre modale */
    }

    /* Style pour le bouton de fermeture */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


    /* Style pour le formulaire */
     #editForm {
        width: 100%; /* Pleine largeur */
        max-width: 500px; /* Largeur maximale */
        margin: 0 auto; /* Centrer horizontalement */
        padding: 20px;
        background-color: #f2f2f2; /* Fond gris clair */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }

    /* Style pour les labels */
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    /* Style pour les champs de texte et de nombre */
    input[type="text"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; /* Inclure le padding et le border dans la largeur */
    }

    /* Style pour les boutons */
    button {
        background-color: #000; /* Couleur de fond vert */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }

    /* Style pour le bouton Annuler */
    button.cancel {
        background-color: #f44336; /* Couleur de fond rouge */
    }

    /* Style pour les boutons au survol */
    button:hover {
        opacity: 0.8;
    }


    /* Style pour le tableau */
    table {
        width: 70%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow:0 0 10px rgba(0, 0, 0, 0.3); 
        
    }

    /* Style pour les cellules du tableau */
    td, th {
        border: 0px solid #dddddd;
        padding: 8px;
        text-align: left;
        font-size: 1.1em;
        font-weight: 400;
    }

    /* Style pour les boutons */
    .action-button {
        width: 100%;
        padding: 10px;
        background-color:  #007bff;;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .action-button:hover {
        background-color: #0056b3;
    }
</style>