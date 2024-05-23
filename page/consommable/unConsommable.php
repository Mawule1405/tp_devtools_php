

<?php
    include "fenetre_modal_cons.php";

    function transformPathToRelative($absolutePath) {
        // Extraire le nom de fichier depuis le chemin absolu
        $fileName = basename($absolutePath);
    
        // Construire le chemin relatif
        $relativePath = "../../image/image_consommable/" . $fileName;
    
        return $relativePath;
    }
function buildConsommable($consommable){

    if(empty($consommable["image"])){
        $image = "../../image/image_consommable/defaut.jpeg";
    }else{
        $image = transformPathToRelative($consommable["image"]);
    }

    $idCons = $consommable["id_cons"];
    $nomCons = $consommable["nom_cons"];
    $qteStock = $consommable["qtestock_cons"];
    $qteSeuil = $consommable["qteseuil_cons"];
    $prixCons = $consommable["prix_unitaire_cons"];
    $idCat = $consommable["id_cat"];

    if($qteSeuil<$qteStock){
        $bg = "background-color : #0f0";
    }
    else{
        $bg = "background-color : #f00";
    }
    $dataFormat = array(
        'idCons' => $idCons,
        'idCat' => $idCat,
        'nomCons' => $nomCons,
        'prix' => $prixCons,
        'image' => $image
    );
     // Encodage du tableau en JSON
     $jsonData = json_encode($dataFormat);

    $reponse = checkConsommableInTables($idCons);
    if ($reponse) {
        $fonction = "deleteConsommableImpossible()";
        
    } else {
        $fonction = "deleteConsommable($jsonData)";
    }
    
   
    echo <<<CON
        <div class="product-container">
            <div class="product-image">
                <img src="$image" alt="Image du produit" class="image" height=200px>
            </div>
            <div class="product-details">
                <h3>$nomCons</h3>
                <div class="quantity-section">
                    <p class="quantity-available" style="$bg">$qteStock</p>
                    <p class="quantity-stock">$qteSeuil</p>
                </div>
                <p class="price">$prixCons FCFA</p>
            </div>
            <div class="product-actions">
                <button type="button" name='actionConsommable' value= '' class="action-button"><img src="../../image/icon/attribuer.svg" alt="Attribuer" class="action-icon" title="Attribuer le consommable" onclick='attribuerConsommable($idCons ,$qteStock)'></button>
                <button type="button" name='actionConsommable' value= '' class="action-button"><img src="../../image/icon/commander.svg" alt="Commander" class="action-icon" title="Commander le consommable" onclick='commanderConsommable($idCons , $prixCons)'></button>
                <button type="button" name='actionConsommable' value= '' class="action-button"><img src="../../image/icon/modifier.svg" alt="Modifier" class="action-icon" title="Modifier le consommable" onclick = ' editConsommable($jsonData)'></button>
                <button type="button" name='actionConsommable' value= '' class="action-button"><img src="../../image/icon/supprimer.svg" alt="Supprimer" class="action-icon" title="Supprimer le consommable" onclick = '$fonction'></button>
            </div>
        </div>
    CON;

}
function buildCategorie($categorie){
    $nom = htmlspecialchars($categorie["nom_cat"], ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars($categorie["id_cat"], ENT_QUOTES, 'UTF-8');
    $nombreCons = count(getConsommableWithId($categorie["id_cat"]));
    $categoryArray = [
        "idCat" => $id,
        "nomCat" => $nom
    ];

    $jsonCategory = json_encode($categoryArray);
    $escapedJsonCategory = htmlspecialchars($jsonCategory, ENT_QUOTES, 'UTF-8');

    if ($nombreCons) {
        $fonction = "deleteCategoryImpossible()";
        
    } else {
        $fonction = "deleteCategory($escapedJsonCategory)";
    }

    echo <<<CAT
        <a href="#categorie_$id" class="product-link">
            <div class="product-header">
                <h2 class="product-name">$nom</h2>
                <h2 class="product-count">$nombreCons</h2>
            </div>
            <button type="button" class="action-button" onclick="editCategory($escapedJsonCategory)">
                <img src="../../image/icon/modifier.svg" alt="Modifier" class="action-icon" title="Modifier la categorie">
            </button>
            <button type="button" class="action-button" onclick="$fonction">
                <img src="../../image/icon/supprimer.svg" alt="Supprimer" class="action-icon" title="Supprimer la categorie">
            </button>
        </a>
    CAT;
}

?>

<script> src="script_consommable.js"</script>
