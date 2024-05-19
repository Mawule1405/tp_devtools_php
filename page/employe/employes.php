<?php

include "un_employe.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données envoyées via POST

    if($_POST['action'] === 'Sauvegarder'){
        var_dump($_POST);
       
        $idEmploye = $_POST['id_emp'];
        $nomEmploye = $_POST['nom_emp'];
        $prenomEmploye = $_POST['prenom_emp'];
        $sexeEmploye = $_POST['sexe_emp'];
        $nationaliteEmploye = $_POST['nationalite_emp'];
        $lieuResEmploye = $_POST['lieu_res_emp'];
        $salaireEmploye = $_POST['salaire_emp'];
        $emailEmploye = $_POST['email_emp'];
        $contactEmploye = $_POST['contact_emp'];
        $dateNaisEmploye = $_POST['date_nais_emp'];
        $dateEmbauEmploye = $_POST['date_embau_emp'];
        $serviceEmploye = $_POST['nom_serv'];
        $niveauEtudeEmploye = $_POST['niveau_etu_emp'];
        $imageEmploye = $_POST['photo_emp'];

    }


    

    // Ici, vous pouvez ajouter le code pour traiter ces données, comme les enregistrer dans une base de données
}else{
    echo "nnnnnnnnnnnnnnnnnnnnnn";
}

  
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

