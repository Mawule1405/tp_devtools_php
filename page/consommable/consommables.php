<?php
    include "unConsommable.php";

    if(isset($_POST['actionCategorie'])){
        if($_POST['actionCategorie'] === "enregistrerCategorie"){
            $nomCat = $_POST['nomCategorie'];
            insertCategorie($nomCat);
        }
        elseif($_POST['actionCategorie'] === "modifierCategorie"){
            $idCat = $_POST['idCategorie'];
            $nomCat = $_POST['nomCategorie'];
            
            updateCategorie($idCat, $nomCat);
        }
        elseif($_POST['actionCategorie'] === "deleteCategorie"){
            $idCat = $_POST['idCategorie'];
            $nomCat = $_POST['nomCategorie'];
            deleteCategorie($idCat);
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
                <button type="button" name="enregistrerConsommable" id="enregistrerConsommable" class="ajoutCategorie" onclick="">Ajout de consommable</button>
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

</script>