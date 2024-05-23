<?php
    include "unConsommable.php";



    if(isset($_POST['actionCategorie'])){
        if($_POST['actionCategorie'] === "enregistrerCategorie"){
            $nomCat = $_POST['nomCategorie'];
            insertCategorie($nomCat);
            $_POST = array();
        }
        elseif($_POST['actionCategorie'] === "modifierCategorie"){
            $idCat = $_POST['idCategorie'];
            $nomCat = $_POST['nomCategorie'];
            
            updateCategorie($idCat, $nomCat);
            $_POST = array();
        }
        elseif($_POST['actionCategorie'] === "deleteCategorie"){
            $idCat = $_POST['idCategorie'];
            $nomCat = $_POST['nomCategorie'];
            deleteCategorie($idCat);
            $_POST = array();
        } 
        
    }
    elseif(isset($_POST['actionConsommable'])){
        if($_POST["actionConsommable"] === "addNewConsommable")
        {
            $nomCons = $_POST["nom_consommable"];
            $catCons = $_POST["categorie_consommable"];
            $qteSeuilCons = $_POST["quantite_seuil"];
            $prixCons = $_POST["prix_unitaire"];

            //Téléchargement de la photo
            $dossierTelechargement = 'C:/wamp64/www/DEV_VERSION_2/image/image_consommable/';
            $photoConsommable = "";
            if(isset($_FILES) && $_FILES['photo_consommable']["name"] !==""){
                $fichierTelecharge = $_FILES['photo_consommable'];
                $nomFichier = basename($fichierTelecharge['name']);
                $photoConsommable = $dossierTelechargement . $nomFichier;
            
                // Vérifier si le dossier de destination existe, sinon le créer
                if (!file_exists($dossierTelechargement)) {
                    mkdir($dossierTelechargement, 0777, true);
                }
            
                // Vérifier si le fichier existe déjà dans le répertoire de destination
                if (!file_exists($photoConsommable)) {
                    // Déplacer le fichier téléchargé vers le dossier cible
                    //Si non on prend la photo par défaut
                    
                    if (!move_uploaded_file($fichierTelecharge['tmp_name'], $photoConsommable)) {
                        $photoConsommable = $dossierTelechargement . "defaut.jpeg";
                    }
                }
            }else{
                $photoConsommable = $dossierTelechargement . "defaut.jpeg";
            }
            

            insertConsommable($nomCons, $catCons, $qteSeuilCons, $prixCons, $photoConsommable);
            $_POST = array();
        }
        elseif($_POST["actionConsommable"] === "attribuerConsommable"){
            
            $employe = $_POST["employe_select"];
            $quantite = $_POST["quantite"];
            $dateDemande = $_POST["date_attribution"];
            $consommable = $_POST["id_consommable"];

            attribuerConsommable($consommable, $employe, $quantite, $dateDemande);
            $_POST = array();
        }
        elseif($_POST["actionConsommable"] === "commanderConsommable"){
            

            $idEmploye = $_POST["employe_select"];
            $idFournisseur = $_POST["fournisseur_select"];
            $dateCommande = $_POST["date_commande"];
            $idConsommable = $_POST["id_consommable"];
            $qteCommande = $_POST["quantite_commande"];
            $idCommande = getNombreCommandes() + 1;

            insertCommande($idCommande, $idEmploye, $idFournisseur, $dateCommande);
            insertAppartient($idConsommable, $idCommande, $qteCommande);
            $_POST = array();
        }
        elseif($_POST["actionConsommable"] === "editConsommable"){
            $idConsommable = $_POST["id_consommable"];
            $nomConsommable = $_POST['nom_consommable'];
            $idCategorie = $_POST['categorie_consommable'];
            $prixConsommable = $_POST['prix_unitaire'];

            //Téléchargement de la photo
            $dossierTelechargement = 'C:/wamp64/www/DEV_VERSION_2/image/image_consommable/';
            $photoConsommable = "";
           
            if(isset($_FILES) && $_FILES['photo_consommable']['name']!==""){
                $fichierTelecharge = $_FILES['photo_consommable'];
                $nomFichier = basename($fichierTelecharge['name']);
                $photoConsommable = $dossierTelechargement . $nomFichier;
            
                // Vérifier si le dossier de destination existe, sinon le créer
                if (!file_exists($dossierTelechargement)) {
                    mkdir($dossierTelechargement, 0777, true);
                }
            
                // Vérifier si le fichier existe déjà dans le répertoire de destination
                if (!file_exists($photoConsommable)) {
                    // Déplacer le fichier téléchargé vers le dossier cible si le fichier n'y ait pas
                    //Sinon on prend la photo par défaut
                    if (!move_uploaded_file($fichierTelecharge['tmp_name'], $photoConsommable)) {
                        $photoConsommable = "";
                    }

                   
                }
            }

            
            updateConsommable($idConsommable, $idCategorie, $nomConsommable, $prixConsommable, $photoConsommable);
            $_POST = array();
        }
        elseif($_POST["actionConsommable"] === "deleteConsommable"){
           
            $idConsommable = $_POST["idConsommable"];
            deleteConsommable($idConsommable);
            $_POST = array();
        }


    }

?>


<link rel="stylesheet" href="style_consommable.css">
<main class = "body-card">
    
    <aside class="aside-card">
        <form action="" method="post" id="recherche-forme" class="search-form">
            <input type="search" name="recherche" id="recherche" class="search-input" placeholder="Rechercher..."> <br>
            <button type="button" name="ajoutCategorieButton", id="ajoutCategorieButton", onclick='addNewCategory()', class="ajoutCategorie"  value="ajoutNewCategorie">Ajouter une catégorie</button>
        </form>
        
        <!--Affichage des informations réduites des employés  -->
        <?php 
                $categories = getAllCategories();
                foreach ($categories as $key => $category) {
                    buildCategorie( $category );
                }
        ?>
    </aside>

    <article >

        <div class="article-card" >
            <form action="" method="post" id="enregistrement-forme" class="enregistrer-forme">
                <input type="search" name="rechercheCons" id="rechercheCons" class="search-input" placeholder="Rechercher un consommable..."> <br>
                <button type="button" name="enregistrerConsommable" id="enregistrerConsommable" class="ajoutCategorie" onclick="addNewConsommable()">Ajout de consommable</button>
            </form>
            <!--Affichage des informations détaillés des employés  -->
            <?php  
            
                $categories = getAllCategories();
                foreach ($categories as $key => $category) {
                    $idCat = $category["id_cat"];
                    $nomCat = $category["nom_cat"];
                    $categoryArray = [
                        "idCat" => $idCat,
                        "nomCat" => $nomCat
                    ];

                    $jsonCategory = json_encode($categoryArray);
                    $escapedJsonCategory = htmlspecialchars($jsonCategory, ENT_QUOTES, 'UTF-8');

                    $consommables = getConsommableWithId($idCat);
                   
                    if($consommables){
                        echo <<<CON
                            <div class="title-categorie">
                                <h2 class='' id='categorie_.$idCat'>$nomCat </h2>
                                <form action="" method="post">
                                    <button type="button" name="actionCategorie" value="modifierCategorie" onclick="editCategory($escapedJsonCategory)">Modifier</button>
                                    
                                </form>
                            </div>
                        CON;

                        echo "<div class ='categorie-consommable' >";
                        foreach( $consommables as $key => $consommable){
                            buildConsommable($consommable);
                        }

                        echo "</div>";
                    }
                   
                }
        
                //Affichage de tous les employés
                

                
            ?>
        </div>
    </article>
</main>




<script>

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

</script>

