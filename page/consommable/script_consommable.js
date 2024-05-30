

function searchConsommables() {
    // Récupérer la zone de recherche
    const rechercheInput = document.getElementById('recherche');

    // Ajouter un écouteur d'événement pour détecter les changements dans la zone de recherche
    rechercheInput.addEventListener('input', function() {
        const searchTerm = rechercheInput.value.toLowerCase(); // Convertir la recherche en minuscules

        // Récupérer tous les éléments consommable
        const consommables = document.querySelectorAll('.product-link');

        // Parcourir tous les consommables et afficher ou masquer en fonction du terme de recherche
        consommables.forEach(function(consommable) {
            const nomConsommable = consommable.querySelector('.product-name').innerText.toLowerCase(); // Récupérer le nom du consommable

            // Vérifier si le nom du consommable contient le terme de recherche
            if (nomConsommable.includes(searchTerm)) {
                consommable.style.display = 'flex'; // Afficher le consommable
            } else {
                consommable.style.display = 'none'; // Masquer le consommable
            }
        });
    });
}



// Appeler la fonction de recherche au chargement de la page
window.onload = function() {
    searchConsommables();
};



function closeModal(idDelaFenetreModale) {

document.getElementById(idDelaFenetreModale).style.display = "none";
}


function addNewCategory() {
    const modal = document.getElementById('categoryModal');
    modal.style.display = 'block';
}


// Fermer la fenêtre modale si l'utilisateur clique en dehors du contenu de la fenêtre
window.addEventListener('click', function(event) {
    const modal = document.getElementById('categoryModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});


//Fonction pour éditer un catégorie
function editCategory(categoryData){
    document.getElementById("id_categorie_modifier").value = categoryData.idCat;
    document.getElementById("nom_categorie_modifier").value = categoryData.nomCat;

    document.getElementById("categoryModalModify").style.display = "block";
}

//Fonction pour supprimer un catégorie
function deleteCategory(categoryData){
    document.getElementById("id_categorie_delete").value = categoryData.idCat;
    document.getElementById("nom_categorie_delete").value = categoryData.nomCat;

    document.getElementById("categoryModalDelete").style.display = "block";
}



//Fonction pour confirmer qu'une catégorie n'est pas supprimable
function deleteCategoryImpossible(){
 

    document.getElementById("categoryModalDeleteImpossible").style.display = "block";
}


//Fonction pour changer la photo du consommable
function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('photoPreview');
    preview.style.display = 'block';
    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}

//Fonction pour enrégistrer un nouveau consommable
function addNewConsommable(){
 document.getElementById("addNewConsommableModal").style.display = "block";
}

//Fonction pour attribuer un consommable
function attribuerConsommable(idCons,quantite){
   
    document.getElementById("quantite").max = quantite;
    document.getElementById("id_consommable").value = idCons;
    document.getElementById("attributConsommableModal").style.display = "block";
}

//Fonction pour commander un consommable
function commanderConsommable(idCons, prix){
   
    document.getElementById("idConsommable").value = idCons;
    document.getElementById("prix_consommable").value = prix;
    document.getElementById("commandConsommableModal").style.display = "block";
}


//Mise à jour automatique du prix
function updatePrixConsommable() {
    const consommableSelect = document.getElementById('consommable_select');
    const prixConsommable = consommableSelect.options[consommableSelect.selectedIndex].dataset.prix;
    document.getElementById('prix_consommable').value = prixConsommable;
    calculateTotal();
}

function calculateTotal() {
    const quantite = document.getElementById('quantite_commande').value;
    const prixConsommable = document.getElementById('prix_consommable').value;
    const montantTotal = quantite * prixConsommable;
    document.getElementById('montant_total').value = montantTotal.toFixed(2) + ' FCFA';
}

// Ajoutez un écouteur pour mettre à jour le montant total lorsque la quantité change
document.getElementById('quantite_commande').addEventListener('input', calculateTotal);


//Fonction pour commander un consommable
function editConsommable(consData){

   document.getElementById("id_consommableA").value = consData.idCons;
   document.getElementById("prix_unitaireA").value = consData.prix;
   document.getElementById('nom_consommableA').value =consData.nomCons;
   document.getElementById("photoPreviewA").src = consData.image;
   document.getElementById("category"+consData.idCat).selected = true;
   document.getElementById("editConsommableModal").style.display = "block";
}


//Fonction pour changer la photo du consommable
function previewImageA(event) {
    var input = event.target;
    var preview = document.getElementById('photoPreviewA');
    preview.style.display = 'block';
    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}

//Fonction pour supprimer un consommable
function deleteConsommable(consommableData){
    document.getElementById("id_consommable_delete").value = consommableData.idCons;
    document.getElementById("nom_consommable_delete").value = consommableData.nomCons;

    document.getElementById("consommableModalDelete").style.display = "block";
}



//Fonction pour confirmer qu'une consommable n'est pas supprimable
function deleteConsommableImpossible(){
 

    document.getElementById("consommableModalDeleteImpossible").style.display = "block";
}
