<?php

    include "./graphi_print.php";


    function build_employe($employe){
        if($employe["photo_emp"])
        {   
            echo "<div> <img src='" . $employe["photo_emp"] . "' alt='' srcset=''> </div>";
        }
    }

    function localPathToUrl($localPath) {
        // Remplacez le chemin racine local par le domaine de votre site web
        $webRoot = ""; // Remplacez example.com par votre nom de domaine
        // Remplacez les backslashes par des slashes
        $url = str_replace('\\', '/', $localPath);
        // Supprimez la partie du chemin local jusqu'au répertoire racine de votre site web
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], $webRoot, $url);
        return $url;
    }
    function create_employe_options($employees){
        $liste = [];

        foreach($employees as $emp => $val){
            $liste[$val["id_emp"]] = $val["id_emp"]." ".$val["nom_emp"]." ".$val["prenom_emp"];
        }

        return $liste;
    }

    function create_service_options($services){
        $liste = [];

        foreach($services as $serv => $val){
            $liste[$val["id_serv"]] = $val["id_serv"]." ".$val["nom_serv"];
        }

        return $liste;
    }


    function verifierValeursNonVides($valeurs) {
        //Fonction pour valider les champs
        foreach ($valeurs as $valeur) {
            // Vérifie si la valeur est vide ou nulle
            if (empty($valeur)) {
                return false;
            }
        }
        // Toutes les valeurs sont non vides ou non nulles
        return true;
    }


    function construireLigne($id, $nom, $qtestock, $qteseuil){
        /*  
            Cette fonction permet de générer une ligne de consommable
            @param: id, nom, qte en stock, qte seuil
            @return: ligne du tableau
        */
        echo <<<MAT
                <tr>
                    <td> $id </td>
                    <td colspan=4> $nom </td>
                    <td> $qtestock </td>
                    <td> $qteseuil </td>
                    <td> <input type="number" name="$id" value="$id"> </td>
                    <td> <input type="checkbox" name="$id" value="$id"> </td>
                </tr>
    MAT;
    }
    

    function construireTableau($idCat){
        /* 
            Cette fonction permet de générer un tableau de consommable d'une même catégorie
            @param: l'identifiant de la catégorie
            @return: un tableau
        */
        $categorie = getOneCategorie($idCat);
        if(!empty($categorie)){
        $cat =$categorie[0];
       
    
        $consos = getConsommablesOfCategorie($idCat);
      
        if(!empty($consos)){
            echo <<<TR
            <tr class= "card-categorie">
                <td colspan="11" class='nom-categorie' > {$cat["nom_cat"]} </td>
            </tr>
    TR;
            foreach($consos as $consommable){
               
            echo <<<HTML
                    <tr data-idcons="{$consommable['id_cons']}" data-nomcons="{$consommable['nom_cons']}">
                    <td>{$consommable['id_cons']}</td>
                    <td colspan='4'>{$consommable['nom_cons']}</td>
                    <td colspan='2'>{$consommable['qtestock_cons']}</td>
                    <td colspan='2'>{$consommable['qteseuil_cons']}</td>
                    <td>
                        <input type='number' name="{$consommable['id_cons']}" value='0' id="qte_{$consommable['id_cons']}" disabled max="{$consommable['qtestock_cons']}" min="0" onchange="checkValue(this)">
                    </td>
                    <td>
                        <input type='checkbox' name="{$consommable['id_cons']}" value="{$consommable['id_cons']}" onchange="toggleInput(this)">
                    </td>
                    </tr>
            HTML;
            }
        }
    }
}


function construireTableauCommande($idCat){
    /* 
        Cette fonction permet de générer un tableau de consommable d'une même catégorie
        @param: l'identifiant de la catégorie
        @return: un tableau
    */
    $categorie = getOneCategorie($idCat);
    if(!empty($categorie)){
    $cat =$categorie[0];
   

    $consos = getConsommablesOfCategorie($idCat);
  
    if(!empty($consos)){
        echo <<<TR
        <tr class= "card-categorie">
            <td colspan="12" class='nom-categorie' ><p> $idCat {$cat["nom_cat"]} </p> </td>
        </tr>
TR;
        foreach($consos as $consommable){
           
        echo <<<HTML
                <tr data-idcons="{$consommable['id_cons']}" data-nomcons="{$consommable['nom_cons']}">
                    <td>{$consommable['id_cons']}</td>

                    <td colspan='8'>{$consommable['nom_cons']}</td>
                    
                    <td colspan=2>
                        <input type='number' name="{$consommable['id_cons']}" value='0' id="qte_{$consommable['id_cons']}" disabled  min="0" onchange="checkValue(this)"  class= "indicatetd">
                    </td>

                    <td>
                        <input type='checkbox' name="{$consommable['id_cons']}" value="{$consommable['id_cons']}" onchange="toggleInput(this)"  class= "indicatetd">
                    </td>
                </tr>
        HTML;
        }
    }
}
}

    
?>

<script>
    function toggleInput(checkbox) {
        var input = document.getElementById("qte_" + checkbox.value);
        input.disabled = !checkbox.checked;
        input.value = checkbox.checked ? '': 0; // Réinitialise la valeur à zéro si la case est cochée, sinon vide
        checkValue(input);
    }

    function checkValue(input) {
        var value = parseFloat(input.value);
        var max = parseFloat(input.max);

        if (isNaN(value) || value <= 0) { // Vérifie si la valeur est numérique et positive
            input.style.color = 'red'; // Affiche en rouge si la valeur est invalide
        } else if (value > max) {
            input.style.color = 'red'; // Affiche en rouge si la valeur dépasse la limite maximale
        } else {
            input.style.color = 'black'; // Couleur par défaut
        }
    }
</script>
