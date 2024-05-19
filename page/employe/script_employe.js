function openModalWithData(id, nom, prenom, sexe, nationalite, lieuRes, salaire, email, contact, dateNais, dateEmbau, service, niveauEtude, photo) {
    document.getElementById('id_emp').value = id;
    document.getElementById('nom_emp').value = nom;
    document.getElementById('prenom_emp').value = prenom;

    if (sexe === 'Masculin') {
        document.getElementById('sexe_m').checked = true;
    } else if (sexe === 'Féminin') {
        document.getElementById('sexe_f').checked = true;
    }

    document.getElementById('current_photo').src = photo;
    document.getElementById('photo_emp').value = photo;
    document.getElementById('nationalite_emp').value = nationalite;
    document.getElementById('lieu_res_emp').value = lieuRes;
    document.getElementById('salaire_emp').value = salaire;
    document.getElementById('email_emp').value = email;
    document.getElementById('contact_emp').value = contact;
    document.getElementById('date_nais_emp').value = dateNais;
    document.getElementById('date_embau_emp').value = dateEmbau;
    document.getElementById('nom_serv').value = service;
    document.getElementById('niveau_etu_emp').value = niveauEtude;

    document.getElementById('myModal').style.display = 'block';
}


function modifierModal(id) {

    console.log(id)
    
    document.getElementById("myModal").style.display = "block";
}

function closeModal(idDelaFenetreModale) {

    document.getElementById(idDelaFenetreModale).style.display = "none";
}


// Fermer la modal si l'utilisateur clique en dehors de celle-ci
window.onclick = function(event) {
    if (event.target == document.getElementById("myModal")) {
        closeModal("myModal");
    }

}

window.onclick = function(event) {
    if (event.target == document.getElementById("myModalNew")) {
        closeModal("myModalNew");
    }

}

//Fonction pour charger la photo choisie sur l'écran
function previewPhoto(event, idDeLimage) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function() {
        const dataURL = reader.result;
        const output = document.getElementById(idDeLimage);
        output.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
}


function saveModification() {

    var idEmploye = document.getElementById("id_emp").value;
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
    var serviceEmploye = document.getElementById("nom_serv").value;
    var niveauEtudeEmploye = document.getElementById("niveau_etu_emp").value;
    var imageEmploye = document.getElementById("current_photo").src.toString();// Récupérer le fichier image
    var nomImageEmploye = imageEmploye.substring(imageEmploye.lastIndexOf('/') + 1);
  
    var boutonEnregistrer = document.getElementById("enregistrerModification");

    boutonEnregistrer.value = "Sauvegarder";
    // Créer un objet FormData pour envoyer les données du formulaire
    var formData = new FormData();
    formData.append('id_emp', idEmploye);
    formData.append('nom_emp', nomEmploye);
    formData.append('prenom_emp', prenomEmploye);
    formData.append('nationalite_emp', nationaliteEmploye);
    formData.append('date_nais_emp', dateNaisEmploye);
    formData.append('date_embau_emp', dateEmbauEmploye);
    formData.append('niveau_etu_emp', niveauEtudeEmploye);
    formData.append('sexe_emp', sexeEmploye);
    formData.append('nom_serv', serviceEmploye);
    formData.append('salaire_emp', salaireEmploye);
    formData.append('photo_emp', nomImageEmploye); // Ajouter l'image au FormData

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'employes.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Gérer la réponse du serveur si nécessaire
            // Par exemple, actualiser la page ou afficher un message de confirmation
            console.log("Envoie reussie")
        } else {
            console.error('Erreur lors de l\'enregistrement des modifications.');
        }
    };
    xhr.send(formData); // Envoyer les données du formulaire au serveur via AJAX
    console.log('FormData Entries:');
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    closeModal('myModal');
    //location.reload(true);
}


function searchEmployees() {
    // Récupérer la zone de recherche
    const rechercheInput = document.getElementById('recherche');

    // Ajouter un écouteur d'événement pour détecter les changements dans la zone de recherche
    rechercheInput.addEventListener('input', function() {
        const searchTerm = rechercheInput.value.toLowerCase(); // Convertir la recherche en minuscules

        // Récupérer tous les éléments employé
        const employes = document.querySelectorAll('.employe-reduite-card');

        // Parcourir tous les employés et afficher ou masquer en fonction du terme de recherche
        employes.forEach(function(employe) {
            const nomEmploye = employe.querySelector('.employe-nom').innerText.toLowerCase(); // Récupérer le nom de l'employé

            // Vérifier si le nom de l'employé contient le terme de recherche
            if (nomEmploye.includes(searchTerm)) {
                employe.style.display = 'flex'; // Afficher l'employé
            } else {
                employe.style.display = 'none'; // Masquer l'employé
            }
        });
    });
}


function enregistrerNouvelEmploye() {
    // Réinitialiser les champs de saisie
    
    
    document.getElementById('current_photo_new').src = "../../image/photo_employe/photo_de_profile.jpeg";
    
    // Afficher la modale
    document.getElementById('myModalNew').style.display = 'block';
}

// Appeler la fonction de recherche au chargement de la page
window.onload = function() {
    searchEmployees();
};


