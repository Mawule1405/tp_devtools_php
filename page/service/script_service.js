

function searchServices() {
    // Récupérer la zone de recherche
    const rechercheInput = document.getElementById('recherche');

    // Ajouter un écouteur d'événement pour détecter les changements dans la zone de recherche
    rechercheInput.addEventListener('input', function() {
        const searchTerm = rechercheInput.value.toLowerCase(); // Convertir la recherche en minuscules

        // Récupérer tous les éléments de service
        const services = document.querySelectorAll('.service-link-container');

        // Parcourir tous les services et afficher ou masquer en fonction du terme de recherche
        services.forEach(function(service) {
            const nomService = service.querySelector('.service-title').innerText.toLowerCase(); // Récupérer le nom du service

            // Vérifier si le nom du service contient le terme de recherche
            if (nomService.includes(searchTerm)) {
                service.style.display = 'flex'; // Afficher le service
            } else {
                service.style.display = 'none'; // Masquer le service
            }
        });
    });
}

window.onload = function() {
    searchServices();
};



function editService(serviceData) {

    // Assigner les valeurs aux champs du formulaire modal
    document.getElementById('id_service').value = serviceData.id_serv;
    document.getElementById('nom_service').value = serviceData.nom_serv;
    document.getElementById('date_creation').value = serviceData.date_serv;
    document.getElementById('mission').value = serviceData.description_serv;
    document.getElementById('employe_responsable_'+serviceData.id_emp_resp).selected = true;

    // Afficher la fenêtre modale
    document.getElementById('myModal').style.display = "block";
}


function createService(){
    //Afficher la fenetre de création d'un nouveau service
    document.getElementById("myModalNew").style.display ="block";
}

function closeModal(idDelaFenetreModale) {

    document.getElementById(idDelaFenetreModale).style.display = "none";
}

function confirmerSuppression(serviceData){
    //Confirmer la suppression
    document.getElementById("idServiceConfirmation").value = serviceData.id_serv+" "+serviceData.nom_serv;
    document.getElementById("confirmationModal").style.display = "block";
}




