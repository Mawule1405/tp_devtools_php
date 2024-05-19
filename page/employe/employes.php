<?php

include "un_employe.php";


  
?>

<link rel="stylesheet" href="style_employe.css">


<main class = "body-card">
    
    <aside class="aside-card">
        <form action="" method="post" id="recherche-forme" class="search-form">
            <input type="search" name="recherche" id="recherche" class="search-input" placeholder="Rechercher...">
        </form>
        <!--Affichage des informations réduites des employés  -->
        <?php 
                $employesReduites = getAllEmployeReduite();
                //Affichage de tous les employés
                
            
                foreach($employesReduites as $index => $employe){
                    if($employe) {
                        buildEmployeReduite($employe);
                    }
                }
        ?>
    </aside>

    <article >

        <div class="article-card" >
            <form action="" method="post" id="enregistrement-forme" class="enregistrer-form">
                <button type="button" name="enregistrerEmploye" id="enregistrerEmploye" onclick="enregistrerNouvelEmploye()">Enrégistrer un(e) nouvel(le) employé(e)</button>
            </form>
            <!--Affichage des informations détaillés des employés  -->
            <?php  
            
                $employes = getAllEmploye();
        
                //Affichage de tous les employés
                

                foreach($employes as $index => $employe){
                    if($employe) {
                        buildEmploye($employe);
                        
                    }
                }
            ?>
        </div>
    </article>
</main>

