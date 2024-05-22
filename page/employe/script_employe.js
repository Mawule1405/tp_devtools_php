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
    document.getElementById('photo_emp_ent').value = photo;
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
    if (nomImageEmploye){
        document.getElementById("photo_emp_ent").value = nomImageEmploye;
    }
    else{
        nomImageEmploye = document.getElementById("photo_emp_ent").value;
    }
    
    var boutonEnregistrer = document.getElementById("enregistrerModification");

    boutonEnregistrer.value = "Sauvegarder";
    
    closeModal('myModal');
    //location.reload(true);
}



function saveModificationNew() {

    var idEmploye = document.getElementById("id_emp_new").value;
    var nomEmploye = document.getElementById("nom_emp_new").value;
    var prenomEmploye = document.getElementById("prenom_emp_new").value;
    var sexeEmploye ;
    if ( document.getElementById('sexe_m_new').checked){
        sexeEmploye = 'Masculin';
    }else{
        sexeEmploye = 'Féminin';
    }

   
    var nationaliteEmploye = document.getElementById("nationalite_emp_new").value;
    var salaireEmploye = document.getElementById("salaire_emp_new").value;
    var dateNaisEmploye = document.getElementById("date_nais_emp_new").value;
    var dateEmbauEmploye = document.getElementById("date_embau_emp_new").value;
    var serviceEmploye = document.getElementById("nom_serv_new").value;
    var niveauEtudeEmploye = document.getElementById("niveau_etu_emp_new").value;
    var imageEmploye = document.getElementById("current_photo_new").src.toString();// Récupérer le fichier image
    var nomImageEmploye = imageEmploye.substring(imageEmploye.lastIndexOf('/') + 1);
    
    
    var boutonEnregistrer = document.getElementById("enregistrerModificationNew");

    boutonEnregistrer.value = "enregistrernouvel";

    
    closeModal('myModalNew');
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
    
    document.getElementById('current_photo_new').src = "../../image/photo_employe/photo_de_profile.jpeg";
    
    // Afficher la modale
    document.getElementById('myModalNew').style.display = 'block';
}

// Appeler la fonction de recherche au chargement de la page
window.onload = function() {
    searchEmployees();
};




