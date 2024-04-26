<?php
   
    $menuItems = array(
        "Accueil" => "./index.php",
        "Employe" => "./employe",
        "Ressources" => "",
        "Statistiques" => "",
        "Aides" => ""
    );

    include "nav.php";
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application de gestion des consommables</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php echo create_nav_bar($menuItems) ?>
        <div id="nom-entreprise">
        <h1>GRAPHIPRINT</h1>
    </div>
    </header>
</body>
</html>  

