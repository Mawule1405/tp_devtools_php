

//Fonction de validation de la modification
function saveModification() {

    var idEmplopye = document.getElementById("id_emp").value;
    var nomEmploye = document.getElementById("nom_emp").value;
    var prenomEmploye = document.getElementById("prenom_emp").value;
    var sexeEmploye ;
    if ( document.getElementById('sexe_m').checked){
        sexeEmploye = 'Masculin';
    }else{
        sexeEmploye = 'Féminin';
    }

    var nationaliteEmploye = document.getElementById("nationalite_emp").value;
    var salaireEmploye = document.getElementById("salaire_emp").value;
    var dateNaisEmploye = document.getElementById("date_nais_emp").value;
    var dateEmbauEmploye = document.getElementById("date_embau_emp").value;
    var serviceEmploye = document.getElementById("service_emp");
    var niveauEtudeEmploye = document.getElementById("niveau_etu_emp").value;
    var imageEmploye = document.getElementById("photo_emp").files[0]; // Récupérer le fichier image

    var boutonEnregistrer = document.getElementById("enregistrerModification");
    boutonEnregistrer.value = "enregistrer";

    // Créer un objet FormData pour envoyer les données du formulaire
    var formData = new FormData();
    formData.append('id_emp', idEmplopye);
    formData.append('nom_emp', nomEmploye);
    formData.append('prenom_emp', prenomEmploye);
    formData.append('nationalite_emp', nationaliteEmploye);
    formData.append('date_nais_emp', dateNaisEmploye);
    formData.append('date_embau_emp', dateEmbauEmploye);
    formData.append('niveau_etu_emp', niveauEtudeEmploye);
    formData.append('sexe_emp', sexeEmploye);
    formData.append('id_serv', serviceEmploye);
    formData.append('photo_emp', imageEmploye); // Ajouter l'image au FormData

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'employes.php', true);
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
