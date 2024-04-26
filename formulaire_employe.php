<link rel="stylesheet" href="style.css">
<?php
   

    function localPathToUrl($localPath) {
        // Remplacez le chemin racine local par le domaine de votre site web
        $webRoot = ""; // Remplacez example.com par votre nom de domaine
        // Remplacez les backslashes par des slashes
        $url = str_replace('\\', '/', $localPath);
        // Supprimez la partie du chemin local jusqu'au répertoire racine de votre site web
        $url = str_replace($_SERVER['DOCUMENT_ROOT'], $webRoot, $url);
        return $url;
    }


    $menuItems = array(
        "Accueil" => "./index.php",
        "Employe" => "./employe",
        "Ressources" => "",
        "Statistiques" => "",
        "Aides" => ""
    );

    $asideItems = array(
        "Liste des employés" =>["liste-employes-id", "#"],
        "Modification d'un employé" => ["modification-employe-id", "#"],
        "Recherche d'un emloyé" =>["recherche-employe-id", "#"],
        "Suppression d'un employé" =>["supprission-employe-id", "#"],
        "Gestions des services" => ["gestion-services-id", "#"]
    );

    include "nav.php";
    echo create_nav_bar($menuItems);
    
    
?>

<div class= div-avec-aside id= div-avec-aside>
    <?php 
        include "aside_page.php";
        create_aside($asideItems);
    ?>

    <main class= main>

        <!-- Traitement et opération à effectuer sur les employés -->
        <article class= employes id= modification-employe-id>
            <h1>Modification d'es informations d'un employé</h1>

            <div class= container-formulaire>
                

            </div>

        </article>
    </main>


</div>



